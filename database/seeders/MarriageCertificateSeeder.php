<?php

namespace Database\Seeders;

use App\Models\MarriageCertificate;
use App\Models\MarriageCertificateHistory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MarriageCertificateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'request_number'    => '472/SKM/001/IX/2024',
                'user_id'           => 6,
                'name'              => 'Muhammad Faris',
                'place_of_birth'    => 'Makassar',
                'date_of_birth'     => '2024-09-12',
                'work_id'           => 3,
                'couple_name'       => 'Risma',
                'partner_address'   => 'Jalan Raya',
                'guardian_name'     => 'Aco',
                'wedding_date'      => '2024-09-12',
                'name_of_the_chief' => 'Wawan',
                'bride_price'       => '10 Gram Gelang Emas',
                'witness_name'      => 'Yanto'
            ]
        ];

        foreach ($data as $key => $value) {
            MarriageCertificate::create($value);
        }

        $history = [
            [
                'certificate_id' => 1,
                'approval_category' => 'Surat Keterangan Menikah',
                'step' => '1',
                'approver_id' => 1,
                'status' => 'Proses',
                'is_active' => '1'
            ],
            [
                'certificate_id' => 1,
                'approval_category' => 'Surat Keterangan Menikah',
                'step' => '2',
                'approver_id' => 2,
                'status' => 'Proses',
            ],
            [
                'certificate_id' => 1,
                'approval_category' => 'Surat Keterangan Menikah',
                'step' => '3',
                'approver_id' => 3,
                'status' => 'Proses',
            ],
        ];

        foreach ($history as $key => $value) {
            MarriageCertificateHistory::create($value);
        }
    }
}
