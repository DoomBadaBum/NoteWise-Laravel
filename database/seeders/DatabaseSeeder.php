<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Note;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $danish = User::create([
            'name' => 'Danish',
            'email' => 'danish@gmail.com',
            'password' => Hash::make('12345678'),
        ]);

        $afiq = User::create([
            'name' => 'Afiq',
            'email' => 'afiq@gmail.com',
            'password' => Hash::make('12345678'),
        ]);

        $faker = Faker::create();

        for ($i = 0; $i < 5; $i++) {
            Note::create([
                'name'        => $faker->sentence(3),
                'description' => $faker->paragraph(2),
                'user_id'     => $danish->id,
            ]);
        }

        for ($i = 0; $i < 5; $i++) {
            Note::create([
                'name'        => $faker->sentence(3),
                'description' => $faker->paragraph(2),
                'user_id'     => $afiq->id,
            ]);
        }

    }
}
