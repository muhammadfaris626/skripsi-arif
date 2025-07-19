<?php

namespace Database\Seeders;

use App\Models\Resident;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ResidentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'family_card_id'      => 1,
                'resident_name'       => 'Abd Karim',
                'resident_number'     => '7371140810770012',
                'gender'              => 'Laki-laki',
                'place_of_birth'      => 'Gowa',
                'date_of_birth'       => '1977-10-08',
                'religion'            => 'Islam',
                'education_id'        => 5,
                'work_id'             => 7,
                'blood_group'         => 'O',
                'marital_status'      => 'Kawin Tercatat',
                'wedding_date'        => '2000-11-15',
                'relationship_status' => 'Kepala Keluarga',
                'citizenship'         => 'WNI',
                'paspor_number'       => '',
                'kitap_number'        => '',
                'father_name'         => 'Pace',
                'mother_name'         => 'Marhuma',
                'phone_number'        => '081222222222',
            ],
            [
                'family_card_id'      => 1,
                'resident_name'       => 'Syamsinar',
                'resident_number'     => '7371146505820010',
                'gender'              => 'Perempuan',
                'place_of_birth'      => 'Takalar',
                'date_of_birth'       => '1982-05-25',
                'religion'            => 'Islam',
                'education_id'        => 5,
                'work_id'             => 2,
                'blood_group'         => 'O',
                'marital_status'      => 'Kawin Tercatat',
                'wedding_date'        => '2000-11-15',
                'relationship_status' => 'Istri',
                'citizenship'         => 'WNI',
                'paspor_number'       => '',
                'kitap_number'        => '',
                'father_name'         => 'Dg Bani',
                'mother_name'         => 'Dg Bollo',
                'phone_number'        => '081333333333',
            ],
        ];

        foreach ($data as $key => $value) {
            Resident::create($value);
            User::create([
                'name' => $value['resident_name'],
                'username' => $value['resident_number'],
                'email' => $value['resident_number'].'@gmail.com',
                'password' => bcrypt($value['resident_number']),
            ])->assignRole('user');
        }
    }
}
