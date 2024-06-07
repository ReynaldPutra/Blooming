<?php

namespace Database\Seeders;

use App\Models\Item;
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
        Item::factory(20)->create();
        Item::create(
            [
                'id' => Item::generateId(),
                'name' => 'Custom Flower',
                'price' => 150000,
                'image' => "https://picsum.photos/seed/custom/640/480/",
                'category' => 'Custom',
                'description' => 'This is Custom Order',
            ]
        );
        User::create(
            [
                'username' => 'admin',
                'email' => 'admin@gmail.com',
                'role' => 'admin',
                'password' => Hash::make('12345678'),
            ],

        );
        User::create(
            [
                'username' => 'user',
                'email' => 'user@gmail.com',
                'role' => 'customer',
                'password' => Hash::make('12345678'),
            ],
        );
    }
}
