<?php

namespace Database\Seeders;

use App\Models\CoverLetter;
use App\Models\CoverLetterHistory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CoverLetterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'request_number'          => '001/RT.001/RW.003/KTB/IX/2024',
                'user_id'                 => 10,
                'resident_id'             => 2,
                'name'                    => 'Syamsinar',
                'place_of_birth'          => 'Takalar',
                'date_of_birth'           => '1982-05-25',
                'gender'                  => 'Perempuan',
                'religion'                => 'Islam',
                'work_id'                 => 2,
                'address'                 => 'Bontojai',
                'resident_number'         => '7371146505820010',
                'family_number'           => '7371141606230012',
                'certificate_category_id' => 1,
                'status'                  => 0
            ],
            [
                'request_number'          => '002/RT.001/RW.003/KTB/IX/2024',
                'user_id'                 => 10,
                'resident_id'             => 2,
                'name'                    => 'Syamsinar',
                'place_of_birth'          => 'Takalar',
                'date_of_birth'           => '1982-05-25',
                'gender'                  => 'Perempuan',
                'religion'                => 'Islam',
                'work_id'                 => 2,
                'address'                 => 'Bontojai',
                'resident_number'         => '7371146505820010',
                'family_number'           => '7371141606230012',
                'certificate_category_id' => 2,
                'status'                  => 1
            ],
            [
                'request_number'          => '003/RT.001/RW.003/KTB/IX/2024',
                'user_id'                 => 10,
                'resident_id'             => 2,
                'name'                    => 'Syamsinar',
                'place_of_birth'          => 'Takalar',
                'date_of_birth'           => '1982-05-25',
                'gender'                  => 'Perempuan',
                'religion'                => 'Islam',
                'work_id'                 => 2,
                'address'                 => 'Bontojai',
                'resident_number'         => '7371146505820010',
                'family_number'           => '7371141606230012',
                'certificate_category_id' => 3,
                'status'                  => 0
            ],
            [
                'request_number'          => '004/RT.001/RW.003/KTB/IX/2024',
                'user_id'                 => 10,
                'resident_id'             => 2,
                'name'                    => 'Syamsinar',
                'place_of_birth'          => 'Takalar',
                'date_of_birth'           => '1982-05-25',
                'gender'                  => 'Perempuan',
                'religion'                => 'Islam',
                'work_id'                 => 2,
                'address'                 => 'Bontojai',
                'resident_number'         => '7371146505820010',
                'family_number'           => '7371141606230012',
                'certificate_category_id' => 4,
                'status'                  => 0
            ],
        ];

        foreach ($data as $key => $value) {
            CoverLetter::create($value);
        }

        $history = [
            [
                'certificate_id'          => 1,
                'certificate_category_id' => 5,
                'step'                    => '1',
                'approver_id'             => 13,
                'status'                  => 'Disetujui',
                'is_active'               => 0
            ],
            [
                'certificate_id'          => 1,
                'certificate_category_id' => 5,
                'step'                    => '2',
                'approver_id'             => 38,
                'status'                  => 'Disetujui',
                'is_active'               => 0
            ],
            [
                'certificate_id'          => 2,
                'certificate_category_id' => 5,
                'step'                    => '1',
                'approver_id'             => 13,
                'status'                  => 'Disetujui',
                'is_active'               => 0
            ],
            [
                'certificate_id'          => 2,
                'certificate_category_id' => 5,
                'step'                    => '2',
                'approver_id'             => 38,
                'status'                  => 'Disetujui',
                'is_active'               => 0
            ],
            [
                'certificate_id'          => 3,
                'certificate_category_id' => 5,
                'step'                    => '1',
                'approver_id'             => 13,
                'status'                  => 'Disetujui',
                'is_active'               => 0
            ],
            [
                'certificate_id'          => 3,
                'certificate_category_id' => 5,
                'step'                    => '2',
                'approver_id'             => 38,
                'status'                  => 'Disetujui',
                'is_active'               => 0
            ],
            [
                'certificate_id'          => 4,
                'certificate_category_id' => 5,
                'step'                    => '1',
                'approver_id'             => 13,
                'status'                  => 'Disetujui',
                'is_active'               => 0
            ],
            [
                'certificate_id'          => 4,
                'certificate_category_id' => 5,
                'step'                    => '2',
                'approver_id'             => 38,
                'status'                  => 'Disetujui',
                'is_active'               => 0
            ],
        ];

        foreach ($history as $key => $value) {
            CoverLetterHistory::create($value);
        }
    }
}
