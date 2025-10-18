<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class MigrateAnnouncementBanners extends Command
{
    protected $signature = 'announcements:migrate-banners';
    protected $description = 'Migrar banners de anuncios de public/storage a storage/app/public';

    public function handle()
    {
        $this->info('🔄 Migrando banners de anuncios...');

        $oldPath = public_path('storage/announcements/banners');
        $migrated = 0;
        $skipped = 0;
        $notFound = 0;

        // Crear directorio en storage/app/public si no existe
        try {
            Storage::disk('public')->makeDirectory('announcements/banners');
            $this->info('✅ Directorio de destino verificado/creado');
        } catch (\Exception $e) {
            $this->error('❌ Error creando directorio: ' . $e->getMessage());
        }

        // Verificar si existe el directorio antiguo
        if (!File::exists($oldPath)) {
            $this->warn("⚠️  No existe directorio antiguo: {$oldPath}");
            $this->info('💡 Todas las nuevas imágenes se guardarán en storage/app/public/announcements/banners/');
            return 0;
        }

        // Obtener todos los archivos
        $files = File::files($oldPath);
        
        if (count($files) === 0) {
            $this->info('✅ No hay archivos en la ubicación antigua para migrar.');
            return 0;
        }

        $this->info("📂 Encontrados " . count($files) . " archivos para migrar...");

        foreach ($files as $file) {
            $filename = $file->getFilename();
            $newPath = 'announcements/banners/' . $filename;

            // Verificar si ya existe en la nueva ubicación
            if (Storage::disk('public')->exists($newPath)) {
                $this->warn("⚠️  Ya existe: {$filename}");
                $skipped++;
                continue;
            }

            // Copiar archivo a la nueva ubicación
            try {
                $content = File::get($file->getPathname());
                Storage::disk('public')->put($newPath, $content);
                $this->info("✅ Migrado: {$filename} (" . number_format(strlen($content) / 1024, 2) . " KB)");
                $migrated++;
            } catch (\Exception $e) {
                $this->error("❌ Error al migrar {$filename}: " . $e->getMessage());
                $notFound++;
            }
        }

        $this->info("\n📊 Resumen:");
        $this->info("   ✅ Migrados: {$migrated}");
        $this->info("   ⚠️  Omitidos: {$skipped}");
        $this->info("   ❌ Errores: {$notFound}");
        $this->info("\n💡 Ubicación final: storage/app/public/announcements/banners/");
        $this->info("💡 Accesibles vía: /storage/announcements/banners/[filename]");

        return 0;
    }
}

