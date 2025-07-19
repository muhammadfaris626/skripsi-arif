<?php

namespace Database\Seeders;

use App\Models\CertificateCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CertificateCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [ 'certificate_category_name' => 'Surat Keterangan Belum Menikah' ], // 1
            [ 'certificate_category_name' => 'Surat Keterangan Domisili' ], // 2
            [ 'certificate_category_name' => 'Surat Keterangan Tidak Mampu' ], // 3
            [ 'certificate_category_name' => 'Surat Keterangan Usaha' ], // 4
            [ 'certificate_category_name' => 'Surat Pengantar' ], // 5
        ];

        foreach ($data as $key => $value) {
            CertificateCategory::create($value);
        }
    }
}
