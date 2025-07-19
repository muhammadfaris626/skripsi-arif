<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'employee_number' => 'lurah',
                'name' => 'Nama Lurah 1',
                'gender' => 'Laki-laki',
                'address' => 'Alamat 1',
                'phone' => 'Nomor Telepon 1',
                'effective_date' => '2024-08-23',
                'position_id' => 1,
                'rank_id' => 1,
                'employee_status' => 'Aktif',
                'blood_group' => 'A',
                'education_id' => 2
            ],
            [
                'employee_number' => '198405022014072005',
                'name' => 'Nani Handayani, SH',
                'gender' => 'Perempuan',
                'address' => 'Alamat 1',
                'phone' => 'Nomor Telepon 1',
                'effective_date' => '2024-08-23',
                'position_id' => 2,
                'rank_id' => 2,
                'employee_status' => 'Aktif',
                'blood_group' => 'A',
                'education_id' => 2
            ],
            [
                'employee_number' => '196909042014092002',
                'name' => 'Nurhayati, SE',
                'gender' => 'Perempuan',
                'address' => 'Alamat 1',
                'phone' => 'Nomor Telepon 1',
                'effective_date' => '2024-08-23',
                'position_id' => 3,
                'rank_id' => 3,
                'employee_status' => 'Aktif',
                'blood_group' => 'A',
                'education_id' => 2
            ],
            [
                'employee_number' => '197908092001122004',
                'name' => 'Syamsidar S, S.Sos',
                'gender' => 'Laki-laki',
                'address' => 'Alamat 1',
                'phone' => 'Nomor Telepon 1',
                'effective_date' => '2024-08-23',
                'position_id' => 4,
                'rank_id' => 1,
                'employee_status' => 'Aktif',
                'blood_group' => 'A',
                'education_id' => 2
            ],
            [
                'employee_number' => 'prt001rw003',
                'name' => 'Pak RT 001 / RW 003',
                'gender' => 'Laki-laki',
                'address' => 'Alamat 1',
                'phone' => 'Nomor Telepon 1',
                'effective_date' => '2024-08-23',
                'position_id' => 13,
                'rank_id' => 1,
                'employee_status' => 'Aktif',
                'blood_group' => 'A',
                'education_id' => 2
            ],
            [
                'employee_number' => 'prw003',
                'name' => 'Pak RW 003',
                'gender' => 'Laki-laki',
                'address' => 'Alamat 1',
                'phone' => 'Nomor Telepon 1',
                'effective_date' => '2024-08-23',
                'position_id' => 38,
                'rank_id' => 1,
                'employee_status' => 'Aktif',
                'blood_group' => 'A',
                'education_id' => 2
            ],
        ];

        foreach ($data as $key => $value) {
            Employee::create($value);
        }
    }
}
