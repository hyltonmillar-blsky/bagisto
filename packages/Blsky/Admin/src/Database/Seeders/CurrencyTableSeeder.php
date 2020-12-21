<?php

namespace Blsky\Admin\Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class CurrencyTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('channels')->delete();

        DB::table('currencies')->delete();

        DB::table('currencies')->insert([
            [
                'id'     => 1,
                'code'   => 'ZAR',
                'name'   => 'Rand',
                'symbol' => 'R ',
            ],
        ]);
    }
}
