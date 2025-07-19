<?php

namespace Database\Seeders;

use App\Models\DomicileCertificate;
use App\Models\DomicileCertificateHistory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DomicileCertificateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'cover_letter_id' => 2,
                'request_number'  => '474/001/KTB/IX/2024',
                'user_id'         => 10,
                'resident_id'     => 2,
                'name'            => 'Syamsinar',
                'resident_number' => '7371146505820010',
                'place_of_birth'  => 'Takalar',
                'date_of_birth'   => '1982-05-05',
                'gender'          => 'Perempuan',
                'marital_status'  => 'Kawin Tercatat',
                'religion'        => 'Islam',
                'work_id'         => 2,
                'address'         => 'Jalan Kapasa Raya, Bontojai, Makassar, Sulawesi Selatan',
                'validity_period' => '',
            ]
        ];
        foreach ($data as $key => $value) {
            DomicileCertificate::create($value);
        }

        $history = [
            [
                'certificate_id' => 1,
                'certificate_category_id' => 2,
                'step' => '1',
                'approver_id' => 2,
                'status' => 'Proses',
                'is_active' => '1'
            ]
        ];
        foreach ($history as $key => $value) {
            DomicileCertificateHistory::create($value);
        }
    }
}
