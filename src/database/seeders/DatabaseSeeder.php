<?php

namespace Database\Seeders;

use App\Models\AppSetting;
use App\Models\Enums\SettingTypes;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Encryption\Encrypter;
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
            $firstUser->assignRole($sAdmin);

        #region Create all permissions
        Permission::firstOrCreate(['name' => 'manage users']);
        Permission::firstOrCreate(['name' => 'manage permissions']);
        Permission::firstOrCreate(['name' => 'modify web map settings']);
        Permission::firstOrCreate(['name' => 'manage docker container']);
        Permission::firstOrCreate(['name' => 'view docker stats']);
        Permission::firstOrCreate(['name' => 'view docker logs']);
        Permission::firstOrCreate(['name' => 'view server mods']);
        Permission::firstOrCreate(['name' => 'manage server mods']);
        Permission::firstOrCreate(['name' => 'manage mod management']);
        #endregion

        #region Application Settings
        // Container Settings
        AppSetting::firstOrCreate(
            [
                'name' => 'Container Name',
                'section' => 'Docker Settings',
                'type' => SettingTypes::String
            ],
            [
                'value' => 'hytale-server',
            ]
        );

        // Mod Manager
        AppSetting::firstOrCreate(
            [
                'name' => 'Mod Manager',
                'section' => 'Mod Management',
                'type' => SettingTypes::Dropdown,
                'options' => json_encode(['Manual','CurseForge'])
            ],
            [
                'value' => 'CurseForge'
            ]
        );
        AppSetting::firstOrCreate(
            [
                'name' => 'CurseForge API Key',
                'section' => 'Mod Management',
                'detail' => 'Is not required, however it is recommended that you use your own API key if you have one.',
                'type' => SettingTypes::Encrypted,
            ],
            [
                'value' => ''
            ]
        );

        // Web Map
        AppSetting::firstOrCreate(
            [
                'name' => 'Enable Map',
                'section' => 'Web Map',
                'type' => SettingTypes::Boolean
            ],
            [
                'value' => false,
            ]
        );

        AppSetting::firstOrCreate(
            [
                'name' => 'URL',
                'section' => 'Web Map',
                'type' => SettingTypes::String
            ],
            [
                'detail' => "Avoid using localhost. If you want to host the map locally, use the host's IP address or serve the map through a proxy, and use the link here.",
                'value' => '',
            ]
        );

        AppSetting::firstOrCreate(
            [
                'name' => 'Port',
                'section' => 'Web Map',
                'type' => SettingTypes::String
            ],
            [
                'detail' => '',
                'value' => '8080',
            ]
        );
        #endregion

        #region CurseForge
        $api = AppSetting::where('section', 'Hidden')->where('name', 'CurseForge API Key')->first();
        if (!$api) {
            $temp = base64_decode('8wFMpBG7z3lxlkPbXfgfwwsrcw3Lk6WqQZ3XCAWjzUk=');
            try {
                $encrypter = new Encrypter($temp, config('app.cipher'));
                $decrypted = $encrypter->decrypt("eyJpdiI6IkF5dnZLYTBvdGZRS2tEaklrR0xiMUE9PSIsInZhbHVlIjoiTlVCa0xRTWlkWFdmVVpxRDlDdE50L1ZHMnZSelV1TnJid1hMQ3JIamw3UTRzNStTNGhzakswRnlrZ3BDUVkrWHhxRUhKa3d5VCtNa3RJeHdjWXhLN1VkSVpxNktvYW5DNzdtNnVueHZtVU09IiwibWFjIjoiZWE0NTY5OGRkYjZiOTkxMDU4ZDdhMGExZmU4ZWRkYzhjMTdlYzkzMTYxNzUyNDY4NTAwMzg3NzFhNmM4YjBlNyIsInRhZyI6IiJ9");

                AppSetting::firstOrCreate(
                    [
                        'name' => 'CurseForge API Key',
                        'section' => 'Hidden',
                        'type' => SettingTypes::Encrypted
                    ],
                    [
                        'value' => encrypt($decrypted)
                    ]
                );
            } catch (\Exception $e) { \Illuminate\Support\Facades\Log::error($e); }
        }
        #endregion
    }
}
