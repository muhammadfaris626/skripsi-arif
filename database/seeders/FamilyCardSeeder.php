<?php

namespace Database\Seeders;

use App\Models\FamilyCard;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FamilyCardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'family_number' => '7371141606230012',
                'name' => 'Abd Karim',
                'address' => 'Bontojai',
                'rt' => '001',
                'rw' => '003',
                'province_id' => '73',
                'regency_id' => '7371',
                'district_id' => '7371111',
                'village_id' => '7371111006',
                'postal_code' => '90241'
            ]
        ];

        foreach ($data as $key => $value) {
            FamilyCard::create($value);
        }
    }
}
