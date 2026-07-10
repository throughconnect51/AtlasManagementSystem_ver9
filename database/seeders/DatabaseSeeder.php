<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // 作成したSeederを配列に登録する
        $this->call([
            SubjectsTableSeeder::class,
            UsersTableSeeder::class,
        ]);
    }
}
