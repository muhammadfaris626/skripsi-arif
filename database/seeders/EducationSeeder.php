<?php

namespace Database\Seeders;

use App\Models\Education;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EducationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [ 'education_name' => 'Tidak / Belum Sekolah' ], // 1
            [ 'education_name' => 'Belum Tamat SD / Sederajat' ], // 2
            [ 'education_name' => 'Tamat SD / Sederajat' ], // 3
            [ 'education_name' => 'SLTP / Sederajat' ], // 4
            [ 'education_name' => 'SLTA / Sederajat' ], // 5
            [ 'education_name' => 'Diploma / II' ], // 6
            [ 'education_name' => 'Akademi / Diploma III / Sarjana Muda' ], // 7
            [ 'education_name' => 'Diploma IV / Strata I' ], // 8
            [ 'education_name' => 'Strata II' ], // 9
            [ 'education_name' => 'Strata III' ], // 10
        ];

        foreach ($data as $key => $value) {
            Education::create($value);
        }
    }
}
