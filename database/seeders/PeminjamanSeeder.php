<?php

namespace Database\Seeders;

use App\Models\borrowed;
use App\Models\DetailsBorrow;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PeminjamanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DetailsBorrow::create([
            'id_items'       => 1, // pastikan item id 1 ada di tabel items
            'amount'         => 5,
            'used_for'       => 'Praktek Jaringan Komputer',
            'class'          => 'XII RPL 2',
            'date_borrowed'  => Carbon::now(),
            'due_date'       => Carbon::now()->addDays(7),
        ]);

        borrowed::create([
            'id_user'            => 1, // pastikan user id 1 ada
            'id_details_borrow'  => 1, // sesuai id dari DetailBorrowSeeder
        ]);
    }
}
