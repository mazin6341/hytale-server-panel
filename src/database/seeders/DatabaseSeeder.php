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
        // Curseforge
        // AppSetting::create([
        //     'name'          => 'Curseforge API Key',
        //     'section'       => 'Curseforge',
        //     'value'         => null,
        //     'is_encrypted'  => true,
        // ]);

        // Web Map
        AppSetting::create([
            'name'          => 'Enable Map',
            'section'       => 'Web Map',
            'value'         => false,
            'is_boolean'    => true,
        ]);

        AppSetting::create([
            'name'          => 'URL',
            'section'       => 'Web Map',
            'value'         => 'http://localhost',
        ]);

        AppSetting::create([
            'name'          => 'Port',
            'section'       => 'Web Map',
            'value'         => '8080',
        ]);
        #endregion
    }
}
