<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\PermissionRegistrar;
use Illuminate\Support\Str;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();
        app()['cache']->forget('spatie.permission.cache');

        $entities = ['user', 'role', 'permission', 'position', 'rank', 'certificate-category', 'work',
            'approval-setting', 'education', 'province', 'regency', 'district',
            'village', 'employee', 'family-card', 'resident', 'birth-certificate',
            'business-certificate', 'marriage-certificate', 'notification',
            'domicile-certificate', 'cover-letter', 'unmarried-certificate', 'inability-certificate'
        ];
        $actions = ['menu', 'create', 'read', 'update', 'delete'];
        $permissions = [];
        foreach ($entities as $entity) {
            foreach ($actions as $action) {
                $permissions["{$entity}: {$action}"] = Permission::create(['name' => "{$entity}: {$action}"]);
            }
        }
        $roles = [
            'root' => array_values($permissions),
            'stakeholder' => [],
            'admin' => array_values($permissions),
            'staff' => [
                $permissions['family-card: menu'], $permissions['family-card: create'], $permissions['family-card: read'], $permissions['family-card: update'],
                $permissions['resident: menu'], $permissions['resident: create'], $permissions['resident: read'], $permissions['resident: update'],
                $permissions['notification: menu'], $permissions['notification: read'], $permissions['notification: update']
            ],
            'user' => [
                $permissions['cover-letter: menu'], $permissions['cover-letter: create'], $permissions['cover-letter: read'],
                $permissions['business-certificate: menu'], $permissions['business-certificate: create'], $permissions['business-certificate: read'],
                $permissions['marriage-certificate: menu'], $permissions['marriage-certificate: create'], $permissions['marriage-certificate: read'],
                $permissions['domicile-certificate: menu'], $permissions['domicile-certificate: create'], $permissions['domicile-certificate: read'],
                $permissions['unmarried-certificate: menu'], $permissions['unmarried-certificate: create'], $permissions['unmarried-certificate: read'],
                $permissions['inability-certificate: menu'], $permissions['inability-certificate: create'], $permissions['inability-certificate: read'],
            ]
        ];
        foreach ($roles as $roleName => $rolePermissions) {
            $role = Role::create(['name' => $roleName]);
            $role->syncPermissions($rolePermissions);
        }
        $users = [
            [
                'name' => 'Root',
                'username' => 'root',
                'email' => 'root@system.com',
                'role' => 'root'
            ],
            [
                'name' => 'Admin',
                'username' => 'admin',
                'email' => 'admin@system.com',
                'role' => 'admin'
            ],
            [
                'name' => 'Nama Lurah 1',
                'username' => 'lurah',
                'email' => 'lurah@system.com',
                'role' => 'staff'
            ],
            [
                'name' => 'Nani Handayani, SH',
                'username' => '198405022014072005',
                'email' => '198405022014072005@system.com',
                'role' => 'staff'
            ],
            [
                'name' => 'Nurhayati, SE',
                'username' => '196909042014092002',
                'email' => '196909042014092002@system.com',
                'role' => 'staff'
            ],
            [
                'name' => 'Syamsidar S, S.Sos',
                'username' => '197908092001122004',
                'email' => '197908092001122004@system.com',
                'role' => 'staff'
            ],
            [
                'name' => 'Pak RT 001 / RW 003',
                'username' => 'prt001rw003',
                'email' => 'prt001rw003@system.com',
                'role' => 'staff'
            ],
            [
                'name' => 'Pak RW 003',
                'username' => 'prw003',
                'email' => 'prw003@system.com',
                'role' => 'staff'
            ],
        ];
        foreach ($users as $userData) {
            User::create([
                'name' => $userData['name'],
                'username' => $userData['username'],
                'email' => $userData['email'],
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
            ])->assignRole($userData['role']);
        }
    }
}
