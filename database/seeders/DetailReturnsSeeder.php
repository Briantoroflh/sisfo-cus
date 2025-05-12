<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DetailReturnsSeeder extends Seeder
{
    public function run(): void
    {
        // Contoh id_details_borrow yang harus sudah ada di tabel details_borrows
        $detailReturns = [
            [
                'id_details_borrow' => 1,
                'date_return' => Carbon::now()->subDays(2),
                'status' => 'approved',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('detail_returns')->insert($detailReturns);
    }
}
