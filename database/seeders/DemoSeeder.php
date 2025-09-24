<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Medicine;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        // Admin demo (opsional, login cepat)
        User::firstOrCreate(
            ['email' => 'admin@demo.test'],
            ['name' => 'Demo Admin', 'password' => Hash::make('password'), 'role' => 'admin']
        );

        // Customer demo
        User::firstOrCreate(
            ['email' => 'customer@demo.test'],
            ['name' => 'Demo Customer', 'password' => Hash::make('password'), 'role' => 'customer']
        );

        // Kategori
        $catAnalgesik = Category::firstOrCreate(['name' => 'Analgesik']);
        $catAntibiotik = Category::firstOrCreate(['name' => 'Antibiotik (Rx)']);

        // Obat non-resep
        Medicine::firstOrCreate(
            ['slug' => 'paracetamol-500'],
            [
                'category_id' => $catAnalgesik->id,
                'name' => 'Paracetamol 500 mg',
                'description' => 'Pereda demam & nyeri',
                'price' => 5000,
                'stock' => 999999,
                'is_prescription_only' => false,
            ]
        );

        // Obat resep
        Medicine::firstOrCreate(
            ['slug' => 'amoxicillin-500'],
            [
                'category_id' => $catAntibiotik->id,
                'name' => 'Amoxicillin 500 mg',
                'description' => 'Antibiotik (butuh resep)',
                'price' => 12000,
                'stock' => 999999,
                'is_prescription_only' => true,
            ]
        );
    }
}
