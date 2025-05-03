<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('items')->insert([
            [
                'item_name' => 'Kabel HDMI',
                'item_image' => 'kabel_hdmi.jpg',
                'code_items' => 'KHDMI001',
                'id_category' => 1,
                'stock' => 3,
                'brand' => 'SONY',
                'status' => 'unused',
                'item_condition' => 'good'
            ],
            [
                'item_name' => 'Kabel USB',
                'item_image' => 'kabel_usb.jpg',
                'code_items' => 'KUSB001',
                'id_category' => 1,
                'stock' => 5,
                'brand' => 'ANKER',
                'status' => 'used',
                'item_condition' => 'good'
            ],
        ]);
    }
}
