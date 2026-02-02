<?php

namespace Database\Seeders;

use App\Models\Clientes;
use Illuminate\Database\Seeder;

class ClientesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear clientes de prueba
        Clientes::create([
            'nombre' => 'Juan',
            'apellido' => 'Pérez',
            'email' => 'juan.perez@example.com',
            'telefono' => '+34 612 345 678',
            'direccion' => 'Calle Principal 123, Madrid'
        ]);

        Clientes::create([
            'nombre' => 'María',
            'apellido' => 'García',
            'email' => 'maria.garcia@example.com',
            'telefono' => '+34 612 345 679',
            'direccion' => 'Avenida Central 456, Barcelona'
        ]);

        Clientes::create([
            'nombre' => 'Carlos',
            'apellido' => 'López',
            'email' => 'carlos.lopez@example.com',
            'telefono' => '+34 612 345 680',
            'direccion' => 'Calle Secundaria 789, Valencia'
        ]);
    }
}
