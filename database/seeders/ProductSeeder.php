<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $baseProducts = [
            ['name' => 'Crypto T-Shirt', 'description' => 'High-quality cotton T-shirt with crypto design.'],
            ['name' => 'Blockchain Mug', 'description' => 'Ceramic mug with blockchain logo.'],
            ['name' => 'Bitcoin Sticker Pack', 'description' => 'Set of 5 vinyl Bitcoin stickers.'],
            ['name' => 'Ethereum Hoodie', 'description' => 'Comfortable hoodie with Ethereum logo.'],
            ['name' => 'Litecoin Cap', 'description' => 'Stylish cap with Litecoin embroidery.'],
        ];

        $products = [];

        for ($i = 1; $i <= 100; $i++) {
            $base = $baseProducts[array_rand($baseProducts)];

            $products[] = [
                'name' => $base['name'] . " #$i",
                'description' => $base['description'],
                // Price between $5 and $100 random with 2 decimals
                'price' => round(mt_rand(500, 10000) / 100, 2),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('products')->insert($products);
    }
}
