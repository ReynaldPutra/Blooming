<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Item;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
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

        Category::create(['name' => 'Fresh Flower', 'description' => 'Fresh Flower']);
        Category::create(['name' => 'Artificial Flower', 'description' => 'DIY Hand Made Flower']);
        $customCategory = Category::create(['name' => 'Custom', 'description' => 'Custom Made Flower']);

        Item::factory(33)->create();
        Item::create(
            [
                'id' => Item::generateId(),
                'name' => 'Custom Flower',
                'price' => 150000,
                'image' => "/asset/small.png",
                'category_id' => $customCategory->id,
                'description' => 'This is Custom Order',
            ]
        );
        User::create(
            [
                'username' => 'admin',
                'email' => 'admin@gmail.com',
                'role' => 'admin',
                'password' => Hash::make('12345678'),
                'verified_at' => Carbon::now(),
            ],

        );
        User::create(
            [
                'username' => 'user',
                'email' => 'user@gmail.com',
                'role' => 'customer',
                'password' => Hash::make('12345678'),
                'verified_at' => Carbon::now(),
            ],
        );
    }
}
