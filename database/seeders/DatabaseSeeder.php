<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call('UsersTableSeeder');

        User::create([
            'name' => 'Walter Paes',
            'username' => 'wpaes',
            'password' => Hash::make('roinuj'),
            'status' => 1
        ]);

        User::create([
            'name' => 'Walter Junior',
            'username' => 'wjunior',
            'password' => Hash::make('roinuj'),
            'status' => 1
        ]);
    }
}
