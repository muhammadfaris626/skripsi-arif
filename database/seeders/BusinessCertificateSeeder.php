<?php

namespace Database\Seeders;

use App\Models\BusinessCertificate;
use App\Models\BusinessCertificateHistory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BusinessCertificateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'cover_letter_id'  => 4,
                'request_number'   => '503/001/KTB/IX/2024',
                'user_id'          => 10,
                'resident_id'      => 2,
                'name'             => 'Syamsinar',
                'resident_number'  => '7371146505820010',
                'place_of_birth'   => 'Takalar',
                'date_of_birth'    => '1982-05-25',
                'religion'         => 'Islam',
                'gender'           => 'Perempuan',
                'work_id'          => 2,
                'address'          => 'Jalan Kapasa Raya, Bontojai, Makassar, Sulawesi Selatan',
                'business_name'    => 'Jual Barang Campuran',
                'business_address' => 'BTN Kodam III',
                'long_term'        => '2022 - Sekarang',
                'validity_period'  => '',
                'description'      => 'Kelengkapan berkas pengurusan BANK'
            ],
        ];

        foreach ($data as $key => $value) {
            BusinessCertificate::create($value);
        }

        $history = [
            [
                'certificate_id' => 1,
                'certificate_category_id' => 4,
                'step' => '1',
                'approver_id' => 3,
                'status' => 'Proses',
                'is_active' => '1'
            ]
        ];

        foreach ($history as $key => $value) {
            BusinessCertificateHistory::create($value);
        }
    }
}
