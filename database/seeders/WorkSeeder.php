<?php

namespace Database\Seeders;

use App\Models\Work;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WorkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [ 'work_name' => 'Belum / Tidak Bekerja' ], // 1
            [ 'work_name' => 'Mengurus Rumah Tangga' ], // 2
            [ 'work_name' => 'Pelajar / Mahasiswa' ], // 3
            [ 'work_name' => 'Pensiunan' ], // 4
            [ 'work_name' => 'Pegawai Negeri Sipil (PNS)' ], // 5
            [ 'work_name' => 'Tentara Nasional Indonesia (TNI)' ], // 6
            [ 'work_name' => 'Buruh Harian Lepas' ], // 7
        ];

        foreach ($data as $key => $value) {
            Work::create($value);
        }
    }
}
