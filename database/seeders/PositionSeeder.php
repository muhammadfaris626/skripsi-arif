<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [ 'position_name' => 'Kepala Kelurahan' ],
            [ 'position_name' => 'Sekretaris Lurah' ],
            [ 'position_name' => 'Seksi Pemerintahan, Ketentraman dan Ketertiban Umum' ],
            [ 'position_name' => 'Kasi Perekonomian, Pembangunan, Sosial dan Penerap' ],
            [ 'position_name' => 'Kepala RT 001 / RW 001' ],
            [ 'position_name' => 'Kepala RT 002 / RW 001' ],
            [ 'position_name' => 'Kepala RT 003 / RW 001' ],
            [ 'position_name' => 'Kepala RT 001 / RW 002' ],
            [ 'position_name' => 'Kepala RT 002 / RW 002' ],
            [ 'position_name' => 'Kepala RT 003 / RW 002' ],
            [ 'position_name' => 'Kepala RT 004 / RW 002' ],
            [ 'position_name' => 'Kepala RT 005 / RW 002' ],
            [ 'position_name' => 'Kepala RT 001 / RW 003' ],
            [ 'position_name' => 'Kepala RT 002 / RW 003' ],
            [ 'position_name' => 'Kepala RT 003 / RW 003' ],
            [ 'position_name' => 'Kepala RT 001 / RW 004' ],
            [ 'position_name' => 'Kepala RT 002 / RW 004' ],
            [ 'position_name' => 'Kepala RT 003 / RW 004' ],
            [ 'position_name' => 'Kepala RT 004 / RW 004' ],
            [ 'position_name' => 'Kepala RT 001 / RW 005' ],
            [ 'position_name' => 'Kepala RT 002 / RW 005' ],
            [ 'position_name' => 'Kepala RT 003 / RW 005' ],
            [ 'position_name' => 'Kepala RT 004 / RW 005' ],
            [ 'position_name' => 'Kepala RT 005 / RW 005' ],
            [ 'position_name' => 'Kepala RT 006 / RW 005' ],
            [ 'position_name' => 'Kepala RT 007 / RW 005' ],
            [ 'position_name' => 'Kepala RT 008 / RW 005' ],
            [ 'position_name' => 'Kepala RT 001 / RW 006' ],
            [ 'position_name' => 'Kepala RT 002 / RW 006' ],
            [ 'position_name' => 'Kepala RT 003 / RW 006' ],
            [ 'position_name' => 'Kepala RT 004 / RW 006' ],
            [ 'position_name' => 'Kepala RT 001 / RW 007' ],
            [ 'position_name' => 'Kepala RT 002 / RW 007' ],
            [ 'position_name' => 'Kepala RT 003 / RW 007' ],
            [ 'position_name' => 'Kepala RT 004 / RW 007' ],
            [ 'position_name' => 'Kepala RW 001' ],
            [ 'position_name' => 'Kepala RW 002' ],
            [ 'position_name' => 'Kepala RW 003' ],
            [ 'position_name' => 'Kepala RW 004' ],
            [ 'position_name' => 'Kepala RW 005' ],
            [ 'position_name' => 'Kepala RW 006' ],
            [ 'position_name' => 'Kepala RW 007' ],
        ];

        foreach ($data as $key => $value) {
            Position::create($value);
        }
    }
}
