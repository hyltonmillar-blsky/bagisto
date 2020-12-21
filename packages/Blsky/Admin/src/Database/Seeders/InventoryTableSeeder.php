<?php

namespace Blsky\Admin\Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class InventoryTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('inventory_sources')->delete();

        DB::table('inventory_sources')->insert([
            'id'             => 1,
            'code'           => 'default',
            'name'           => 'Default',
            'contact_name'   => 'Demo Warehouse',
            'contact_email'  => 'warehouse@example.com',
            'contact_number' => 1234567899,
            'status'         => 1,
            'country'        => 'ZA',
            'state'          => 'KZN',
            'street'         => 'Demo Street',
            'city'           => 'Demo',
            'postcode'       => '3629',
        ]);
    }
}