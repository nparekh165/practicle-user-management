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
        // User::factory(10)->create();

        User::factory()->create([
            'first_name' => 'home_page',
            'last_name' => 'user',
            'dob' => '1990-01-14',
            'gender' => 'Male',
            'mobile' => '9345345352',
        ]);
    }
}
