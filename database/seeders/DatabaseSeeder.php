<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Status;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $roles = [
            [
                'name' => 'Administrator',
                'description' => 'Can add, edit users and publish applications',
            ],
            [
                'name' => 'Developer',
                'description' => 'Can add/edit applications',
            ],
        ];

        $app_status = [
            [
                'name' => 'Completed',
                'description' => 'All the possible application versions have been released',
                'created_by' => 1,
            ],
            [
                'name' => 'Released',
                'description' => 'The application is in use but new versions will be released in the future',
                'created_by' => 1,
            ],
            [
                'name' => 'In Development',
                'description' => 'No version of the application has been officially released',
                'created_by' => 1,
            ],
        ];

        $user_accounts = [[
            'first_name' => 'Brian',
            'middle_name' => '',
            'last_name' => 'Mutugi',
            'email' => 'brian.mutugi@un.org',
            'password' => Hash::make('P@55w.rd'),
            'role_id' => 1,
        ],
            [
                'first_name' => 'Paul',
                'middle_name' => '',
                'last_name' => 'Maina',
                'email' => 'paul.maina@un.org',
                'password' => Hash::make('P@55w.rd'),
                'role_id' => 1,
            ],
            [
                'first_name' => 'Kamal',
                'middle_name' => '',
                'last_name' => 'Naim',
                'email' => 'kamal.naim@un.org',
                'password' => Hash::make('P@55w.rd'),
                'role_id' => 1,
            ],
            [
                'first_name' => 'Saiful',
                'middle_name' => '',
                'last_name' => 'Ridwan',
                'email' => 'saiful.ridwan@un.org',
                'password' => Hash::make('P@55w.rd'),
                'role_id' => 1,
            ],
        ];

        $apps = [[
            'name' => '',
            'description' => '',
        ]];

        foreach ($roles as $role) {
            Role::create($role);
        }

        foreach ($user_accounts as $account) {
            User::create($account);
        }
        foreach ($app_status as $status) {
            Status::create($status);
        }

    }
}
