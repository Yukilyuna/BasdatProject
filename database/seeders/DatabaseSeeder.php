<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan kategori sudah ada dulu
        $this->call([
            CategoryTreeSeeder::class,
            MedicineCatalogSeeder::class,
        ]);
    }
}
