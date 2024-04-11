<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Meowveloper',
            'email' => 'admin@gmail.com',
            'phone' => '09253348439',
            'address' => 'Yangon',
            'role' => 'admin',
            'password' => Hash::make('admin123'),
            'gender' => 'male'
        ]);

        User::create([
            'name' => 'Kyaw Kyaw',
            'email' => 'customer@gmail.com',
            'phone' => '09253348439',
            'address' => 'Yangon',
            'role' => 'user',
            'password' => Hash::make('customer123'),
            'gender' => 'male'
        ]);

        Category::create([
            'name' => 'Drinks',
            'created_at' => Carbon::now()
        ]);

        Category::create([
            'name' => 'Pizza',
            'created_at' => Carbon::now()
        ]);

        Category::create([
            'name' => 'Snacks',
            'created_at' => Carbon::now()
        ]);

        Category::create([
            'name' => 'Myanmar Traditional Foods',
            'created_at' => Carbon::now()
        ]);

        Category::create([
            'name' => 'Seasonal Juices',
            'created_at' => Carbon::now()
        ]);
    }
}
