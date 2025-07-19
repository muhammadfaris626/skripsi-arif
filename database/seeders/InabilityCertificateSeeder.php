<?php

namespace Database\Seeders;

use App\Models\InabilityCertificate;
use App\Models\InabilityCertificateHistory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InabilityCertificateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'cover_letter_id' => 3,
                'request_number'  => '401/001/KTB/IX/2024',
                'user_id'         => 10,
                'resident_id'     => 2,
                'name'            => 'Syamsinar',
                'resident_number' => '7371146505820010',
                'place_of_birth'  => 'Takalar',
                'date_of_birth'   => '1982-05-05',
                'gender'          => 'Perempuan',
                'marital_status'  => 'Belum Kawin',
                'religion'        => 'Islam',
                'work_id'         => 3,
                'address'         => 'Jalan Kapasa Raya, Bontojai, Makassar, Sulawesi Selatan',
                'description'     => 'Kelengkapan Berkas Di Rumah Sakit',
                'validity_period' => '',
            ]
        ];
        foreach ($data as $key => $value) {
            InabilityCertificate::create($value);
        }

        $history = [
            [
                'certificate_id' => 1,
                'certificate_category_id' => 3,
                'step' => '1',
                'approver_id' => 4,
                'status' => 'Proses',
                'is_active' => '1'
            ]
        ];
        foreach ($history as $key => $value) {
            InabilityCertificateHistory::create($value);
        }
    }
}
