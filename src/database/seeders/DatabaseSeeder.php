<?php

namespace Database\Seeders;

use App\Models\AppSetting;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $sAdmin = Role::firstOrCreate(['name' => 'Super Admin']);

        $firstUser = User::find(1);
        if ($firstUser)
            User::find(1)->assignRole($sAdmin);

        #region Create all permissions
        Permission::firstOrCreate(['name' => 'manage users']);
        Permission::firstOrCreate(['name' => 'manage permissions']);
        Permission::firstOrCreate(['name' => 'modify web map settings']);
        Permission::firstOrCreate(['name' => 'manage docker container']);
        Permission::firstOrCreate(['name' => 'view docker stats']);
        Permission::firstOrCreate(['name' => 'view docker logs']);
        Permission::firstOrCreate(['name' => 'view server mods']);
        Permission::firstOrCreate(['name' => 'manage server mods']);
        #endregion

        #region Application Settings
        // Container Settings
        AppSetting::firstOrCreate(
            [
                'name' => 'Container Name',
                'section' => 'Docker Settings'
            ],
            [
                'value' => 'hytale-server',
            ]
        );

        // Web Map
        AppSetting::firstOrCreate(
            [
                'name' => 'Enable Map',
                'section' => 'Web Map'
            ],
            [
                'value' => false,
                'is_boolean' => true,
            ]
        );

        AppSetting::firstOrCreate(
            [
                'name' => 'URL',
                'section' => 'Web Map'
            ],
            [
                'detail' => "Avoid using localhost. If you want to host the map locally, use the host's IP address or serve the map through a proxy, and use the link here.",
                'value' => '',
            ]
        );

        AppSetting::firstOrCreate(
            [
                'name' => 'Port',
                'section' => 'Web Map'
            ],
            [
                'detail' => '',
                'value' => '8080',
            ]
        );
        #endregion
    }
}
