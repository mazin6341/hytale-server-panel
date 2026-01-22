<?php

namespace Database\Seeders;

use App\Models\AppSetting;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $sAdmin = Role::create(['name' => 'Super Admin']);
        User::find(1)->assignRole($sAdmin);

        #region Application Settings
        // Container Settings
        AppSetting::create([
            'name'          => 'Container Name',
            'section'       => 'Docker Settings',
            'value'         => 'hytale-server',
        ]);

        // Web Map
        AppSetting::create([
            'name'          => 'Enable Map',
            'section'       => 'Web Map',
            'value'         => false,
            'is_boolean'    => true,
        ]);

        AppSetting::create([
            'name'          => 'URL',
            'detail'        => "Avoid using localhost. If you want to host the map locally, use the host's IP address or serve the map through a proxy, and use the link here.",
            'section'       => 'Web Map',
            'value'         => '',
        ]);

        AppSetting::create([
            'name'          => 'Port',
            'detail'        => '',
            'section'       => 'Web Map',
            'value'         => '8080',
        ]);
        #endregion
    }
}
