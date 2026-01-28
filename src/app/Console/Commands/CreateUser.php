<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new user';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle() {
        $this->info('Creating a new user.');

        $isFirstUser = User::count() === 0;

        $name = $this->ask('What is the user\'s name?');
        $email = $this->ask('What is the user\'s email address?');
        $password = $this->secret('Please enter a password');
        $passwordConfirmation = $this->secret('Please confirm the password');

        $userData = [
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $passwordConfirmation,
        ];

        $validator = Validator::make($userData, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails()) {
            $this->info('User not created. Please see the errors below:');

            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }

            return 1;
        }

        try {
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
            ]);

            if ($isFirstUser) {
                $this->info('This is the first user. Assigning "Super Admin" role.');
                $role = Role::firstOrCreate(['name' => 'Super Admin', 'guard_name' => 'web']);
                $user->assignRole($role);
                $this->info('User created successfully and assigned "Super Admin" role.');
            } else
                $this->info('User created successfully.');
        } catch (\Exception $e) {
            $this->error('An error occurred while creating the user: ' . $e->getMessage());
            return 1;
        }

        return 0;
    }
}