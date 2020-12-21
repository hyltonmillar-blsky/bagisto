<?php

namespace Blsky\Admin\Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class AdminsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('admins')->delete();

        DB::table('admins')->insert([
            [
            'id'         => 1,
            'name'       => 'Blsky Admin',
            'email'      => 'admin@blsky.co.za',
            'password'   => bcrypt('Blsky!@3'),
            'api_token'  => Str::random(80),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'status'     => 1,
            'role_id'    => 1,
            ],
            [
                'id'         => 2,
                'name'       => 'Demo',
                'email'      => 'demo@blsky.co.za',
                'password'   => bcrypt('demo123'),
                'api_token'  => Str::random(80),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'status'     => 1,
                'role_id'    => 2,
                ]
        ]);
    }
}
