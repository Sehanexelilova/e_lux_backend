<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productsRecord = [
            'category_id' => 1,
            'brand_id' => 1,
            'product_name' => 'Sample Product',
            'product_code' => 'SP001',
            'product_color' => json_encode(['Red']),
            'other_photos' => json_encode(['Red']),
            'family_color' => 'Red Family',
            'product_size' => json_encode(['M']),
            'group_code' => 'GC01',
            'product_price' => 100,
            'product_discount' => 10,
            'discount_type' => 'Percentage',
            'final_price' => 90,
            'description' => 'Sample product description',
            'wash_care' => 'Machine wash cold',
            'fabric' => '100% Cotton',
            'pattern' => 'Solid',
            'sleeve' => 'Short',
            'fit' => 'Regular',
            'meta_title' => 'Sample Product Meta Title',
            'meta_keyword' => 'Sample, Product',
            'meta_description' => 'Sample product meta description',
            'is_feature' => 'No',
            'status' => 1,
            'origin' => 'Abroad',
        ];

        Product::insert($productsRecord);
    }
}
