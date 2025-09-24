<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\Medicine;

class MedicineCatalogSeeder extends Seeder
{
    public function run(): void
    {
        // === DAFTAR PRODUK PER SUBKATEGORI (key = slug kategori anak) ===
        // Catatan: jika sebuah slug tidak ada di DB, seeder akan melewati slug tsb.
        $catalog = [

            // Batuk, Pilek & Flu
            'batuk-flu' => [
                ['Paracetamol 500 mg', false, 8000],
                ['Dextromethorphan Sirup 60 ml', false, 15000],
                ['Guaifenesin Tablet 200 mg', false, 12000],
                ['Ambroxol 30 mg', false, 12000],
                ['Pseudoephedrine 60 mg', true, 18000],
                ['Oseltamivir 75 mg', true, 75000],
                ['Vitamin C 500 mg', false, 14000],
            ],
            'balsem-minyak-esensial' => [
                ['Minyak Kayu Putih 60 ml', false, 22000],
                ['Minyak Telon 60 ml', false, 26000],
                ['Balsem Hangat 20 g', false, 18000],
                ['Aromatherapy Roll On', false, 25000],
                ['Minyak Angin Aromatik', false, 17000],
            ],
            'perawatan-herbal' => [
                ['Echinacea Kapsul 500 mg', false, 38000],
                ['Ekstrak Jahe Merah', false, 32000],
                ['Madu Herbal 250 g', false, 45000],
                ['Propolis Tetes', false, 52000],
                ['Kunyit Asam Sirup', false, 28000],
            ],
            'nasal-spray-dekongestan' => [
                ['Saline Nasal Spray', false, 30000],
                ['Oxymetazoline 0.05% Spray', false, 35000],
                ['Xylometazoline 0.1% Spray', false, 35000],
                ['Fluticasone Nasal Spray', true, 90000],
            ],
            'untuk-bayi-anak' => [
                ['Paracetamol Drops Anak', false, 22000],
                ['Sirup Batuk Anak 60 ml', false, 24000],
                ['Saline Tetes Hidung Bayi', false, 20000],
                ['Minyak Telon Plus 60 ml', false, 27000],
                ['Oral Rehydration Salt (ORS) Anak', false, 9000],
            ],

            // Demam & Nyeri
            'pereda-demam-nyeri' => [
                ['Ibuprofen 200 mg', false, 15000],
                ['Asam Mefenamat 500 mg', true, 20000],
                ['Naproxen 250 mg', true, 24000],
                ['Diclofenac 50 mg', true, 22000],
                ['Paracetamol Effervescent 500 mg', false, 17000],
                ['Ketoprofen Gel 30 g', false, 42000],
            ],
            'terapi-panas-dingin' => [
                ['Plester Panas', false, 18000],
                ['Bantal Panas Reusable', false, 60000],
                ['Kompres Dingin Gel Pack', false, 35000],
                ['Spray Pendingin Otot', false, 28000],
            ],

            // Masalah Pencernaan
            'asam-lambung-gerd' => [
                ['Antasida Tablet Kunyah', false, 12000],
                ['Omeprazole 20 mg', false, 25000],
                ['Esomeprazole 20 mg', true, 42000],
                ['Sucralfate Sirup 100 ml', true, 48000],
                ['Domperidone 10 mg', true, 22000],
            ],
            'mual-muntah' => [
                ['Ondansetron 4 mg', true, 52000],
                ['Metoclopramide 10 mg', true, 18000],
                ['Oralit (ORS) 1 sachet', false, 7000],
                ['Jahe Instan Anti Mual', false, 15000],
            ],
            'diare' => [
                ['Loperamide 2 mg', false, 15000],
                ['Attapulgite 650 mg', false, 12000],
                ['Probiotik Kapsul', false, 38000],
                ['Zinc 20 mg', false, 18000],
                ['Larutan Rehidrasi 200 ml', false, 12000],
            ],
            'infeksi-cacing' => [
                ['Albendazole 400 mg', false, 18000],
                ['Mebendazole 500 mg', false, 17000],
                ['Pyrantel Pamoate Sirup 15 ml', false, 16000],
            ],
            'sembelit-wasir' => [
                ['Bisacodyl 5 mg', false, 16000],
                ['Laktulosa Sirup 100 ml', false, 42000],
                ['Psyllium Husk 100 g', false, 52000],
                ['Salep Wasir 15 g', false, 38000],
            ],

            // Alergi
            'obat-alergi' => [
                ['Cetirizine 10 mg', false, 16000],
                ['Loratadine 10 mg', false, 16000],
                ['Fexofenadine 120 mg', false, 26000],
                ['Prednisone 5 mg', true, 14000],
                ['Mometasone Nasal Spray', true, 95000],
            ],
            'pereda-gatal' => [
                ['Kalamin Lotion 100 ml', false, 24000],
                ['Hydrocortisone 1% Krim 10 g', false, 18000],
                ['Antihistamin Krim 10 g', false, 17000],
                ['Gel Lidokain 2% 10 g', false, 23000],
            ],

            // Masalah Mata
            'gatal-kering-merah' => [
                ['Tetes Mata Lubrikan (Artificial Tears)', false, 24000],
                ['Tetes Mata Dekongestan', false, 22000],
                ['Olopatadine 0.1% Eye Drops', true, 72000],
                ['Chloramphenicol Eye Drops', true, 28000],
            ],
            'lainnya' => [
                ['Salep Mata Vitamin A', false, 21000],
                ['Kompres Mata Hangat', false, 25000],
            ],

            // Masalah THT
            'sariawan-herpes' => [
                ['Gel Mulut Benzocaine', false, 25000],
                ['Acyclovir 200 mg', true, 30000],
                ['Benzydamine Mouthwash 120 ml', false, 38000],
            ],
            'obat-kumur-antiseptik' => [
                ['Povidone Iodine Kumur 100 ml', false, 26000],
                ['Chlorhexidine Mouthwash 250 ml', false, 52000],
            ],
            'obat-tetes-telinga' => [
                ['Carbamide Peroxide Ear Drops', false, 32000],
                ['Ciprofloxacin Ear Drops', true, 54000],
            ],
            'kebersihan-hidung' => [
                ['Neti Pot + Saline', false, 68000],
                ['Saline Rinse Sachet', false, 22000],
            ],
            'pelega-tenggorokan' => [
                ['Lozenges Menthol 8 butir', false, 12000],
                ['Spray Tenggorokan Antiseptik', false, 38000],
                ['Permen Pelega Mint', false, 9000],
            ],
        ];

        // === SEED ===
        foreach ($catalog as $catSlug => $items) {
            $category = Category::where('slug', $catSlug)->first();
            if (!$category) {
                $this->command?->warn("Kategori tidak ditemukan: {$catSlug} (dilewati)");
                continue;
            }

            foreach ($items as $it) {
                [$name, $rx, $price] = $it;
                $slug = Str::slug($name);

                // pastikan slug unik lintas kategori
                if (Medicine::where('slug', $slug)->exists()) {
                    $slug .= '-' . $category->id;
                }

                Medicine::updateOrCreate(
                    ['slug' => $slug],
                    [
                        'name'                 => $name,
                        'category_id'          => $category->id,
                        'price'                => $price,
                        'is_prescription_only' => (bool) $rx,
                    ]
                );
            }
        }

        // Tambahkan "pengisi" untuk subkategori lain yang belum terisi sama sekali
        $filled = array_keys($catalog);
        $otherChildren = Category::whereNotNull('parent_id')
            ->whereNotIn('slug', $filled)
            ->get();

        foreach ($otherChildren as $cat) {
            for ($i = 1; $i <= 4; $i++) {
                $name = $cat->name . ' Sample ' . $i;
                $slug = Str::slug($name) . '-' . $cat->id;

                Medicine::updateOrCreate(
                    ['slug' => $slug],
                    [
                        'name'                 => $name,
                        'category_id'          => $cat->id,
                        'price'                => rand(9000, 65000),
                        'is_prescription_only' => (bool) random_int(0, 1),
                    ]
                );
            }
        }
    }
}
