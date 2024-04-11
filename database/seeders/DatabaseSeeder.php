<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\Color;
use App\Models\Customer;
use App\Models\PaymentType;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        User::create([
            'name' => 'Meowveloper',
            'email' => 'admin@gmail.com',
            'role' => 'owner',
            'password' => Hash::make('admin123')
        ]);

        PaymentType::create([
            'name' => 'KBZ pay'
        ]);
        PaymentType::create([
            'name' => 'KBZ banking'
        ]);
        PaymentType::create([
            'name' => 'Cash on Delivery'
        ]);

        

        Category::create([
            'name' => 'Mini Paw Key-chain',
            'description' => 'Best seller'
        ]);
        Category::create([
            'name' => 'Big Paw Key-chain',
            'description' => 'Worth the money'
        ]);
        Category::create([
            'name' => 'Accessories',
            'description' => 'Receive Delivery and Save your Time'
        ]);

        Color::create([
            'name' => 'pink',
        ]);
        Color::create([
            'name' => 'blue',
        ]);
        Color::create([
            'name' => 'red',
        ]);
        Color::create([
            'name' => 'black',
        ]);

        Customer::create([
            'name' => 'Kyaw Kyaw',
            'phone' => '098776544',
            'address' => 'Yangon'
        ]);
    }
}
