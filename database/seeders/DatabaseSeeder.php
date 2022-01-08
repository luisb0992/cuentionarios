<?php

namespace Database\Seeders;

use App\Enums\RolEnum;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Limpiar tablas antes de ejecutar cualquier seeder
        $this->truncateTables([
            'users'
        ]);

        // Usuario administrador.
        User::create([
            'name' => 'Administrador',
            'lastname' => 'System',
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin123'),
            'rol_id' => RolEnum::ADMIN
        ]);
    }

    /**
     * Limpiar varias tablas a la vez.
     *
     * @param array $tables Tablas a limpiar.
     * @return void
     */
    public function truncateTables(array $tables): void
    {
        // desactivar la revisión de claves foráneas
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');

        foreach ($tables as $table) {
            DB::table($table)->truncate();
        }

        // activar la revisión de claves foráneas
        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
    }
}
