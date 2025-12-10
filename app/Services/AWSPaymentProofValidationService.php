<?php

namespace App\Services;

use Aws\Rekognition\RekognitionClient;
use Aws\Textract\TextractClient;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Models\PaymentProofTemplate;

class AWSPaymentProofValidationService
{
    protected $rekognition;
    protected $textract;

    public function __construct()
    {
        $config = [
            'version' => 'latest',
            'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
            'credentials' => [
                'key' => env('AWS_ACCESS_KEY_ID'),
                'secret' => env('AWS_SECRET_ACCESS_KEY'),
            ],
        ];

        $this->rekognition = new RekognitionClient($config);
        $this->textract = new TextractClient($config);
    }

    /**
     * Valida un comprobante de pago usando AWS Rekognition
     * 
     * @param string $imagePath Ruta del archivo en storage
     * @param string|null $selectedBank Banco específico seleccionado por el usuario
     * @return array ['status' => 'valid|suspicious|fake', 'score' => 0-100, 'details' => [...]]
     */
    public function validateProof(string $imagePath, ?string $selectedBank = null): array
    {
        try {
            // Obtener el contenido de la imagen
            $imageContent = Storage::get($imagePath);

            // 1. Detección de texto con Textract (OCR avanzado) - PRIMERO
            $textDetection = $this->detectTextWithRekognition($imageContent);
            
            // 2. Análisis EXIF (rápido, solo metadatos)
            $exifAnalysis = $this->analyzeEXIF($imageContent);
            
            // 3. Comparación contra plantillas del banco específico (RÁPIDO)
            $templateComparison = $this->compareWithTemplates($imageContent, $selectedBank);
            
            // 4. Análisis de imagen con Rekognition (labels, calidad)
            $imageAnalysis = $this->analyzeImageWithRekognition($imageContent);
            
            // Calcular score de confianza
            $score = $this->calculateConfidenceScore([
                'text' => $textDetection,
                'analysis' => $imageAnalysis,
                'exif' => $exifAnalysis,
                'template' => $templateComparison,
            ]);
            
            // Determinar status
            $status = $this->determineStatus($score, $textDetection, $imageAnalysis, $exifAnalysis, $templateComparison);
            
            return [
                'status' => $status,
                'score' => $score,
                'details' => [
                    // Comparación de plantillas
                    'template_match' => $templateComparison['best_match'] ?? null,
                    'template_similarity' => round($templateComparison['similarity'] ?? 0),
                    
                    // Datos de texto
                    'has_text' => $textDetection['has_text'] ?? false,
                    'text_words' => $textDetection['words_count'] ?? 0,
                    'low_confidence_words' => $textDetection['low_confidence_words'] ?? 0,
                    'confidence_std_dev' => round($textDetection['confidence_std_dev'] ?? 0, 2),
                    'detected_text' => substr($textDetection['text'] ?? '', 0, 200),
                    
                    // Datos de imagen
                    'image_quality' => $imageAnalysis['quality'] ?? 'unknown',
                    'labels_count' => $imageAnalysis['labels_count'] ?? 0,
                    'has_document' => $imageAnalysis['has_document'] ?? false,
                    'compression_quality' => $imageAnalysis['compression_quality'] ?? 'unknown',
                    
                    // Datos de EXIF
                    'is_edited' => $exifAnalysis['is_edited'] ?? false,
                    'editing_software' => $exifAnalysis['editing_software'] ?? null,
                    'suspicious_metadata' => $exifAnalysis['suspicious_metadata'] ?? false,
                    'exif_editing_score' => $exifAnalysis['editing_score'] ?? 0,
                ],
            ];
            
        } catch (\Exception $e) {
            Log::error('Error validating payment proof with AWS: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            
            return [
                'status' => 'error',
                'score' => 0,
                'details' => [
                    'error' => $e->getMessage(),
                ],
            ];
        }
    }

    /**
     * Compara la imagen con plantillas del banco específico (OPTIMIZADO CON CACHÉ)
     */
    protected function compareWithTemplates(string $imageContent, ?string $selectedBank = null): array
    {
        try {
            // OPTIMIZACIÓN 1: Cargar plantillas cacheadas de BD (sin llamadas a AWS)
            $cachedTemplates = [];
            
            if ($selectedBank && $selectedBank !== 'otro') {
                // Solo cargar plantillas del banco seleccionado
                $cachedTemplates = PaymentProofTemplate::getByBank($selectedBank);
            } else {
                // Fallback: cargar todas (máximo 3)
                $cachedTemplates = PaymentProofTemplate::orderBy('created_at', 'desc')
                    ->limit(3)
                    ->get()
                    ->map(function ($template) {
                        return [
                            'filename' => $template->filename,
                            'labels' => $template->labels,
                        ];
                    })
                    ->toArray();
            }
            
            if (empty($cachedTemplates)) {
                return [
                    'has_templates' => false,
                    'best_match' => null,
                    'similarity' => 0,
                    'selected_bank' => $selectedBank,
                ];
            }
            
            // OPTIMIZACIÓN 2: Solo 1 llamada a AWS (para el comprobante del usuario)
            $targetLabels = $this->rekognition->detectLabels([
                'Image' => ['Bytes' => $imageContent],
                'MaxLabels' => 10,
                'MinConfidence' => 70,
            ])->get('Labels');
            
            $matches = [];
            $bestMatch = null;
            $highestSimilarity = 0;
            
            // OPTIMIZACIÓN 3: Comparar contra labels cacheados (0 llamadas a AWS)
            foreach ($cachedTemplates as $template) {
                $templateName = basename($template['filename'], '.jpg');
                $templateName = basename($templateName, '.jpeg');
                $templateName = basename($templateName, '.png');
                
                try {
                    // Usar labels cacheados (sin llamar a AWS)
                    $templateLabels = $template['labels'];
                    
                    // Calcular similitud
                    $similarity = $this->calculateSimilarity($targetLabels, $templateLabels);
                    
                    $matches[] = [
                        'template' => $templateName,
                        'similarity' => $similarity,
                    ];
                    
                    if ($similarity > $highestSimilarity) {
                        $highestSimilarity = $similarity;
                        $bestMatch = $templateName;
                    }
                    
                } catch (\Exception $e) {
                    // Error silencioso, continuar con siguientes plantillas
                }
            }
            
            return [
                'has_templates' => true,
                'best_match' => $bestMatch,
                'similarity' => $highestSimilarity,
                'selected_bank' => $selectedBank,
                'matches' => $matches,
            ];
            
        } catch (\Exception $e) {
            Log::error('Error in template comparison: ' . $e->getMessage());
            return [
                'has_templates' => false,
                'best_match' => null,
                'similarity' => 0,
                'selected_bank' => $selectedBank,
            ];
        }
    }
    
    /**
     * Calcula similitud entre dos conjuntos de labels
     */
    protected function calculateSimilarity(array $labels1, array $labels2): float
    {
        if (empty($labels1) || empty($labels2)) {
            return 0.0;
        }
        
        // Extraer nombres de labels
        $names1 = array_map(function($label) {
            return strtolower($label['Name']);
        }, $labels1);
        
        $names2 = array_map(function($label) {
            return strtolower($label['Name']);
        }, $labels2);
        
        // Calcular intersección y unión
        $intersection = count(array_intersect($names1, $names2));
        $union = count(array_unique(array_merge($names1, $names2)));
        
        // Índice de Jaccard (similitud)
        $similarity = $union > 0 ? ($intersection / $union) * 100 : 0;
        
        return $similarity;
    }

    /**
     * Analiza metadatos EXIF para detectar ediciones
     */
    protected function analyzeEXIF(string $imageContent): array
    {
        try {
            // Guardar temporalmente para análisis EXIF
            $tempPath = sys_get_temp_dir() . '/temp_proof_' . uniqid() . '.jpg';
            file_put_contents($tempPath, $imageContent);
            
            $exifData = @exif_read_data($tempPath);
            unlink($tempPath);
            
            if (!$exifData) {
                return [
                    'has_exif' => false,
                    'is_edited' => false,
                    'editing_software' => null,
                    'suspicious_metadata' => false,
                    'editing_score' => 0,
                ];
            }
            
            $editingSoftware = null;
            $isEdited = false;
            $suspiciousMetadata = false;
            $editingScore = 0;
            
            // Detectar software de edición conocido
            $editingSoftwareList = [
                'adobe photoshop', 'photoshop', 'gimp', 'paint.net',
                'pixlr', 'photoscape', 'snapseed', 'picsart',
                'lightroom', 'photopea', 'canva', 'inkscape'
            ];
            
            if (isset($exifData['Software'])) {
                $software = strtolower($exifData['Software']);
                foreach ($editingSoftwareList as $editor) {
                    if (strpos($software, $editor) !== false) {
                        $editingSoftware = $exifData['Software'];
                        $isEdited = true;
                        $editingScore += 3;
                        break;
                    }
                }
            }
            
            // Verificar fechas sospechosas
            if (isset($exifData['DateTime']) && isset($exifData['DateTimeOriginal'])) {
                $dateTime = strtotime($exifData['DateTime']);
                $dateTimeOriginal = strtotime($exifData['DateTimeOriginal']);
                
                // Si la fecha de modificación es muy diferente a la original
                $diff = abs($dateTime - $dateTimeOriginal);
                if ($diff > 300) { // Más de 5 minutos = posible edición
                    $suspiciousMetadata = true;
                    $editingScore += 2;
                }
            }
            
            // Verificar si faltan datos EXIF típicos de fotos reales
            $expectedFields = ['Make', 'Model', 'DateTime', 'DateTimeOriginal'];
            $missingFields = 0;
            foreach ($expectedFields as $field) {
                if (!isset($exifData[$field])) {
                    $missingFields++;
                }
            }
            
            if ($missingFields >= 3) {
                // Faltan muchos campos = posible captura de pantalla o edición
                $suspiciousMetadata = true;
                $editingScore += 1;
            }
            
            return [
                'has_exif' => true,
                'is_edited' => $isEdited,
                'editing_software' => $editingSoftware,
                'suspicious_metadata' => $suspiciousMetadata,
                'editing_score' => $editingScore,
            ];
            
        } catch (\Exception $e) {
            return [
                'has_exif' => false,
                'is_edited' => false,
                'editing_software' => null,
                'suspicious_metadata' => false,
                'editing_score' => 0,
            ];
        }
    }

    /**
     * Detecta texto usando AWS Textract (OCR avanzado con análisis de confianza)
     */
    protected function detectTextWithRekognition(string $imageContent): array
    {
        try {
            $result = $this->textract->detectDocumentText([
                'Document' => [
                    'Bytes' => $imageContent,
                ],
            ]);

            $blocks = $result->get('Blocks');
            $text = '';
            $totalConfidence = 0;
            $wordsCount = 0;
            $lowConfidenceWords = 0;
            $confidenceVariance = [];

            // Procesar bloques de tipo WORD
            foreach ($blocks as $block) {
                if ($block['BlockType'] === 'WORD') {
                    $text .= $block['Text'] . ' ';
                    $confidence = $block['Confidence'] ?? 0;
                    $totalConfidence += $confidence;
                    $confidenceVariance[] = $confidence;
                    $wordsCount++;
                    
                    // Palabras con confianza baja (<70%) son sospechosas
                    if ($confidence < 70) {
                        $lowConfidenceWords++;
                    }
                }
            }

            $avgConfidence = $wordsCount > 0 ? $totalConfidence / $wordsCount : 0;
            $hasText = $wordsCount > 0;
            
            // Calcular desviación estándar de confianza (variación alta = edición)
            $confidenceStdDev = 0;
            if (count($confidenceVariance) > 1) {
                $mean = array_sum($confidenceVariance) / count($confidenceVariance);
                $variance = array_sum(array_map(function($x) use ($mean) {
                    return pow($x - $mean, 2);
                }, $confidenceVariance)) / count($confidenceVariance);
                $confidenceStdDev = sqrt($variance);
            }

            return [
                'text' => trim($text),
                'confidence' => $avgConfidence / 100, // Normalizar a 0-1
                'words_count' => $wordsCount,
                'has_text' => $hasText,
                'low_confidence_words' => $lowConfidenceWords,
                'confidence_std_dev' => $confidenceStdDev,
            ];

        } catch (\Exception $e) {
            Log::error('Error in AWS Textract detectText: ' . $e->getMessage());
            return [
                'text' => '',
                'confidence' => 0,
                'words_count' => 0,
                'has_text' => false,
                'low_confidence_words' => 0,
                'confidence_std_dev' => 0,
            ];
        }
    }

    /**
     * Analiza la imagen con AWS Rekognition (calidad, labels, documentos, UI elements)
     */
    protected function analyzeImageWithRekognition(string $imageContent): array
    {
        try {
            // 1. Detectar labels (objetos, escenas, conceptos)
            $labelsResult = $this->rekognition->detectLabels([
                'Image' => [
                    'Bytes' => $imageContent,
                ],
                'MaxLabels' => 30,
                'MinConfidence' => 50,
            ]);

            $labels = $labelsResult->get('Labels');
            $labelsCount = count($labels);
            $labelNames = array_map(function($label) {
                return $label['Name'];
            }, $labels);
            
            // Buscar etiquetas relacionadas con documentos/comprobantes REALES
            $documentRelatedLabels = ['Receipt', 'Paper', 'Invoice', 'Ticket'];
            $hasDocument = false;
            
            foreach ($labels as $label) {
                if (in_array($label['Name'], $documentRelatedLabels)) {
                    $hasDocument = true;
                    break;
                }
            }

            // 2. Detectar moderación de contenido (spam, contenido inapropiado)
            $moderationResult = $this->rekognition->detectModerationLabels([
                'Image' => [
                    'Bytes' => $imageContent,
                ],
                'MinConfidence' => 60,
            ]);

            $moderationLabels = $moderationResult->get('ModerationLabels');
            $hasSuspiciousContent = count($moderationLabels) > 0;

            // 3. Analizar calidad y compresión de la imagen
            $imageSize = strlen($imageContent);
            $imageInfo = getimagesizefromstring($imageContent);
            
            $quality = 'unknown';
            $compressionQuality = 'unknown';
            
            if ($imageInfo) {
                $width = $imageInfo[0];
                $height = $imageInfo[1];
                $pixels = $width * $height;
                
                // Calcular ratio de compresión (bytes por pixel)
                $bytesPerPixel = $imageSize / $pixels;
                
                // Imágenes muy comprimidas (posible reedición múltiple)
                if ($bytesPerPixel < 0.1) {
                    $compressionQuality = 'very_low'; // Posible señal de edición
                } elseif ($bytesPerPixel < 0.3) {
                    $compressionQuality = 'low';
                } elseif ($bytesPerPixel < 0.8) {
                    $compressionQuality = 'medium';
                } else {
                    $compressionQuality = 'high';
                }
                
                // Calidad general
                if ($labelsCount >= 5 && $imageSize > 50000) {
                    $quality = 'good';
                } elseif ($labelsCount >= 3 && $imageSize > 20000) {
                    $quality = 'medium';
                } elseif ($labelsCount > 0) {
                    $quality = 'poor';
                }
            }

            // 4. DETECTAR POSIBLES EDICIONES
            $editingScore = 0;
            
            // Muy comprimida = posible reedición
            if ($compressionQuality === 'very_low') {
                $editingScore += 2;
            }
            
            // Poca calidad con mucho texto = posible texto añadido
            if ($quality === 'poor' && $labelsCount < 3) {
                $editingScore += 1;
            }

            return [
                'quality' => $quality,
                'labels_count' => $labelsCount,
                'has_document' => $hasDocument,
                'has_suspicious_content' => $hasSuspiciousContent,
                'compression_quality' => $compressionQuality,
                'editing_score' => $editingScore,
            ];

        } catch (\Exception $e) {
            Log::error('Error in AWS Rekognition analyzeImage: ' . $e->getMessage());
            return [
                'quality' => 'unknown',
                'labels_count' => 0,
                'has_document' => false,
                'has_suspicious_content' => false,
                'is_likely_screenshot' => false,
                'has_ui_elements' => false,
                'screenshot_score' => 0,
                'suspicious_resolution' => false,
            ];
        }
    }

    /**
     * Calcula score de confianza (0-100) con EXIF + OCR + Comparación de Plantillas
     */
    protected function calculateConfidenceScore(array $data): int
    {
        $score = 0;
        
        // BONIFICACIÓN POR SIMILITUD CON PLANTILLAS (MUY IMPORTANTE - peso aumentado)
        if (isset($data['template']['has_templates']) && $data['template']['has_templates']) {
            $similarity = $data['template']['similarity'] ?? 0;
            
            if ($similarity >= 95) {
                $score += 45; // Match casi perfecto = MUY confiable
            } elseif ($similarity >= 80) {
                $score += 35; // Muy similar a plantilla real
            } elseif ($similarity >= 60) {
                $score += 20; // Bastante similar
            } elseif ($similarity >= 40) {
                $score += 10; // Algo similar
            }
            // Si <40% de similitud, no bonifica (sospechoso)
        }
        
        // 1. Tiene texto detectado (+30 puntos base)
        if ($data['text']['has_text']) {
            $score += 30;
            
            // Bonificación por cantidad de palabras (+15 puntos)
            $wordsCount = $data['text']['words_count'];
            if ($wordsCount >= 20) {
                $score += 15;
            } elseif ($wordsCount >= 10) {
                $score += 12;
            } elseif ($wordsCount >= 5) {
                $score += 8;
            } elseif ($wordsCount >= 2) {
                $score += 4;
            }
            
            // Confianza del OCR (+10 puntos)
            $score += ($data['text']['confidence'] * 10);
        }
        
        // 2. Parece un documento (+10 puntos)
        if ($data['analysis']['has_document']) {
            $score += 10;
        }
        
        // 3. Calidad de imagen (+5 puntos)
        if ($data['analysis']['quality'] === 'good') {
            $score += 5;
        } elseif ($data['analysis']['quality'] === 'medium') {
            $score += 3;
        }
        
        // PENALIZACIONES POR EDICIÓN/MANIPULACIÓN
        
        // 4. Software de edición detectado en EXIF (-35 puntos)
        if (isset($data['exif']['is_edited']) && $data['exif']['is_edited']) {
            $score -= 35;
        }
        
        // 5. EXIF editing score (-10 puntos por cada punto)
        if (isset($data['exif']['editing_score'])) {
            $score -= ($data['exif']['editing_score'] * 10);
        }
        
        // 6. Palabras con baja confianza OCR (señal de texto editado)
        if (isset($data['text']['low_confidence_words']) && $data['text']['low_confidence_words'] > 0) {
            $lowConfidencePercent = ($data['text']['low_confidence_words'] / max($data['text']['words_count'], 1)) * 100;
            if ($lowConfidencePercent > 30) {
                $score -= 30; // Más del 30% de palabras dudosas
            } elseif ($lowConfidencePercent > 15) {
                $score -= 20; // 15-30% de palabras dudosas
            } elseif ($lowConfidencePercent > 5) {
                $score -= 10; // 5-15% de palabras dudosas
            }
        }
        
        // 7. Alta variación en confianza OCR (diferentes fuentes/ediciones)
        // PERO solo si la similitud con plantilla es baja (si es alta, es normal tener variación)
        if (isset($data['text']['confidence_std_dev']) && $data['text']['confidence_std_dev'] > 20) {
            $templateSimilarity = $data['template']['similarity'] ?? 0;
            if ($templateSimilarity < 80) {
                $score -= 20; // Variación alta + baja similitud = posible edición
            } else {
                $score -= 5; // Variación alta pero coincide con plantilla = OK
            }
        }
        
        // 8. Compresión muy baja (posible reedición múltiple)
        // PERO solo penalizar si NO coincide con plantilla
        if (isset($data['analysis']['compression_quality']) && 
            $data['analysis']['compression_quality'] === 'very_low') {
            $templateSimilarity = $data['template']['similarity'] ?? 0;
            if ($templateSimilarity < 70) {
                $score -= 15; // Baja compresión + no coincide = sospechoso
            }
            // Si coincide con plantilla, no penalizar (es normal en screenshots)
        }
        
        // 9. Metadatos sospechosos (-15 puntos)
        if (isset($data['exif']['suspicious_metadata']) && $data['exif']['suspicious_metadata']) {
            $score -= 15;
        }
        
        // 10. NO coincide con ninguna plantilla (<40% similitud) (-25 puntos)
        if (isset($data['template']['has_templates']) && $data['template']['has_templates']) {
            if ($data['template']['similarity'] < 40) {
                $score -= 25; // No se parece a ningún comprobante real
            }
        }
        
        // 11. Contenido inapropiado/spam (-50 puntos)
        if ($data['analysis']['has_suspicious_content']) {
            $score -= 50;
        }
        
        return min(100, max(0, (int)$score));
    }

    /**
     * Determina el status final con EXIF + OCR + Comparación de Plantillas
     */
    protected function determineStatus(int $score, array $textDetection, array $imageAnalysis, array $exifAnalysis, array $templateComparison): string
    {
        $templateSimilarity = $templateComparison['similarity'] ?? 0;
        $hasTemplates = $templateComparison['has_templates'] ?? false;
        
        // REGLAS ESTRICTAS PARA EDICIONES DETECTADAS
        
        // Si tiene contenido inapropiado/spam, es FAKE
        if ($imageAnalysis['has_suspicious_content']) {
            return 'fake';
        }
        
        // Si NO coincide con ninguna plantilla (<70% similitud) Y hay plantillas, revisar señales de edición
        if ($hasTemplates && $templateSimilarity < 70) {
            // PRIMERA VERIFICACIÓN: Compresión muy baja = reedición múltiple
            if (isset($imageAnalysis['compression_quality']) && $imageAnalysis['compression_quality'] === 'very_low') {
                return 'fake'; // Imagen reedita múltiples veces
            }
            
            // Si tiene señales claras de edición → FAKE directamente
            $hasEditingSignals = false;
            
            // Variación alta de confianza OCR
            if (isset($textDetection['confidence_std_dev']) && $textDetection['confidence_std_dev'] > 12) {
                $hasEditingSignals = true;
            }
            
            // Muchas palabras con baja confianza
            $lowConfidencePercent = 0;
            if (isset($textDetection['low_confidence_words']) && isset($textDetection['words_count'])) {
                $lowConfidencePercent = ($textDetection['low_confidence_words'] / max($textDetection['words_count'], 1)) * 100;
            }
            if ($lowConfidencePercent > 10) {
                $hasEditingSignals = true;
            }
            
            // Si tiene señales de edición O similitud <30% → FAKE
            if ($hasEditingSignals || $templateSimilarity < 30) {
                return 'fake';
            }
            
            // Si no tiene señales claras pero similitud 30-69% → SUSPICIOUS
            return 'suspicious';
        }
        
        // Si fue editado con software (Photoshop, etc.) ES FAKE (más estricto)
        if ($exifAnalysis['is_edited']) {
            // Solo si coincide 90%+ con plantilla Y tiene buen OCR, puede ser SUSPICIOUS
            if ($hasTemplates && $templateSimilarity >= 90 && $textDetection['confidence'] >= 0.90) {
                return 'suspicious';
            }
            // Cualquier otra edición detectada → FAKE
            return 'fake';
        }
        
        // REGLAS BASADAS EN SIMILITUD CON PLANTILLA (más importante)
        
        // Si coincide 90%+ con plantilla, es probablemente VÁLIDO (incluso con pequeñas imperfecciones)
        if ($hasTemplates && $templateSimilarity >= 90) {
            // Solo validar que tenga texto
            if ($textDetection['has_text']) {
                return 'valid';
            }
        }
        
        // Si coincide 70-89% con plantilla Y tiene buen OCR, es VÁLIDO
        if ($hasTemplates && $templateSimilarity >= 70 && $textDetection['confidence'] >= 0.85) {
            return 'valid';
        }
        
        // REGLAS ESTRICTAS: Similitud 50-69% con plantilla
        
        if ($hasTemplates && $templateSimilarity >= 50 && $templateSimilarity < 70) {
            // Similitud intermedia = posible edición
            
            // 1. Si tiene compresión muy baja (reedición) → FAKE directamente
            if (isset($imageAnalysis['compression_quality']) && $imageAnalysis['compression_quality'] === 'very_low') {
                return 'fake';
            }
            
            // 2. Si tiene variación alta de fuentes (>15%) → FAKE
            if (isset($textDetection['confidence_std_dev']) && $textDetection['confidence_std_dev'] > 15) {
                return 'fake';
            }
            
            // 3. Si muchas palabras con baja confianza (>15%) → FAKE
            $lowConfidencePercent = 0;
            if (isset($textDetection['low_confidence_words']) && isset($textDetection['words_count'])) {
                $lowConfidencePercent = ($textDetection['low_confidence_words'] / max($textDetection['words_count'], 1)) * 100;
            }
            if ($lowConfidencePercent > 15) {
                return 'fake';
            }
            
            // 4. Si no coincide bien (<68%) → FAKE (muy diferente a la plantilla)
            if ($templateSimilarity < 68) {
                return 'fake';
            }
            
            // Si pasa todas las validaciones → SUSPICIOUS
            return 'suspicious';
        }
        
        // Si coincide 30-49% con plantilla → FAKE (muy diferente a plantillas reales)
        if ($hasTemplates && $templateSimilarity >= 30 && $templateSimilarity < 50) {
            return 'fake';
        }
        
        // Si no tiene texto detectado, es SUSPICIOUS
        if (!$textDetection['has_text']) {
            return 'suspicious';
        }
        
        // EVALUACIÓN POR SCORE (solo si no hay plantillas o no aplicaron reglas anteriores)
        
        // Score mayor a 65: válido
        if ($score >= 65) {
            return 'valid';
        }
        
        // Score entre 35-64: dudoso
        if ($score >= 35) {
            return 'suspicious';
        }
        
        // Score menor a 35: probable fraude
        return 'fake';
    }
}

