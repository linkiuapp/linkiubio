<?php

namespace Database\Seeders;

use App\Shared\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        // Generar contraseña segura o usar de variable de entorno
        $password = env('SUPER_ADMIN_PASSWORD', Str::random(16));
        
        $user = User::create([
            'name' => 'Super Admin',
            'email' => env('SUPER_ADMIN_EMAIL', 'admin@linkiu.bio'),
            'password' => Hash::make($password),
            'email_verified_at' => now(),
            'role' => 'super_admin',
            'last_login_at' => null,
            'store_id' => null,
        ]);
        
        // Log de la contraseña solo en desarrollo
        if (app()->environment('local')) {
            \Log::info('SuperAdmin creado', [
                'email' => $user->email,
                'password' => $password,
                'note' => 'Guardar esta contraseña de forma segura'
            ]);
            
            $this->command->info('SuperAdmin creado:');
            $this->command->info('Email: ' . $user->email);
            $this->command->info('Password: ' . $password);
            $this->command->warn('⚠️ Guarda esta contraseña de forma segura!');
        }
    }
} 