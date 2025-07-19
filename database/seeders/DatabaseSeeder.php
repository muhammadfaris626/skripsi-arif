<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolesAndPermissionsSeeder::class,
            PositionSeeder::class,
            RankSeeder::class,
            WorkSeeder::class,
            CertificateCategorySeeder::class,
            EducationSeeder::class,
            IndoRegionProvinceSeeder::class,
            IndoRegionRegencySeeder::class,
            IndoRegionDistrictSeeder::class,
            IndoRegionVillageSeeder::class,
            EmployeeSeeder::class,
            FamilyCardSeeder::class,
            ResidentSeeder::class,
            ApprovalSettingSeeder::class,
            CoverLetterSeeder::class,
            DomicileCertificateSeeder::class,
            BusinessCertificateSeeder::class,
            UnmarriedCertificateSeeder::class,
            InabilityCertificateSeeder::class
        ]);
    }
}
