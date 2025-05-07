<?php

namespace Database\Seeders;

use App\Models\DetailReturns;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DetailsReturnSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DetailReturns::create([
            'id_borrowed' => 1,
            'date_return' => Carbon::now()->subDays(rand(1, 30))->format('Y-m-d'),
        ]);
    }
}
