<?php

namespace Database\Seeders;

use App\Models\BirthCertificate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BirthCertificateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'Firmanto',
                'gender' => 'L',
                'religion' => 'Islam',
                'place_of_birth' => 'Makassar',
                'date_of_birth' => '2024-10-10',
                'time_of_birth' => '05:14',
                'family_card_id' => 1,
                'father_name' => 'Wanto',
                'mother_name' => 'Wanti',
                'address' => 'Jalan raya',
                'child_from' => '2',
                'give_birth_in' => 'Rumah Sakit',
                'birth_location' => 'RS Sayang Rakyat',
                'weight' => '4',
                'birth_certificate' => 'SK/08/09/2024/00567'
            ]
        ];

        foreach ($data as $key => $value) {
            BirthCertificate::create($value);
        }
    }
}
