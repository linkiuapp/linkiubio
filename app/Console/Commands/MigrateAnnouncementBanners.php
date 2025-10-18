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

        // Verificar si existe el directorio antiguo
        if (!File::exists($oldPath)) {
            $this->info('✅ No hay archivos en la ubicación antigua.');
            return 0;
        }

        // Crear directorio en storage/app/public si no existe
        Storage::disk('public')->makeDirectory('announcements/banners');

        // Obtener todos los archivos
        $files = File::files($oldPath);

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
                Storage::disk('public')->put(
                    $newPath,
                    File::get($file->getPathname())
                );
                $this->info("✅ Migrado: {$filename}");
                $migrated++;
            } catch (\Exception $e) {
                $this->error("❌ Error al migrar {$filename}: " . $e->getMessage());
            }
        }

        $this->info("\n📊 Resumen:");
        $this->info("   Migrados: {$migrated}");
        $this->info("   Omitidos: {$skipped}");
        $this->info("\n💡 Puedes verificar los archivos en: storage/app/public/announcements/banners/");

        return 0;
    }
}

