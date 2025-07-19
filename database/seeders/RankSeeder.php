<?php

namespace Database\Seeders;

use App\Models\Rank;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'rank_name' => 'Penata Tingkat I'
            ],
            [
                'rank_name' => 'Penata Muda'
            ],
            [
                'rank_name' => 'Penata'
            ]
        ];

        foreach ($data as $key => $value) {
            Rank::create($value);
        }
    }
}
