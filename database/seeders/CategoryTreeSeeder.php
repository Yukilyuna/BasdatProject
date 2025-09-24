<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategoryTreeSeeder extends Seeder
{
    public function run(): void
    {
        $tree = [
            'Batuk, Pilek, & Flu' => [
                'Batuk & Flu', 'Balsem & Minyak Esensial', 'Perawatan Herbal', 'Nasal Spray & Dekongestan', 'Untuk Bayi & Anak'
            ],
            'Demam & Nyeri' => [
                'Pereda Demam & Nyeri', 'Terapi Panas & Dingin', 'Perawatan Herbal', 'Untuk Bayi & Anak'
            ],
            'Masalah Pencernaan' => [
                'Asam Lambung & GERD', 'Mual & Muntah', 'Diare', 'Infeksi Cacing', 'Sembelit & Wasir'
            ],
            'Alergi' => ['Obat Alergi', 'Pereda Gatal'],
            'Masalah Mata' => ['Gatal, Kering, & Merah', 'Lainnya'],
            'Masalah THT' => ['Sariawan & Herpes', 'Obat Kumur & Antiseptik', 'Obat Tetes Telinga', 'Kebersihan Hidung', 'Pelega Tenggorokan'],
        ];

        foreach ($tree as $group => $subs) {
            $parent = Category::firstOrCreate(
                ['slug' => Str::slug($group)],
                ['name' => $group, 'parent_id' => null]
            );
            foreach ($subs as $name) {
                Category::firstOrCreate(
                    ['slug' => Str::slug($name)],
                    ['name' => $name, 'parent_id' => $parent->id]
                );
            }
        }
    }
}
