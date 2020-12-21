<?php

namespace Blsky\Admin\Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class CategoryTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('categories')->delete();

        DB::table('category_translations')->delete();

        $now = Carbon::now();

        DB::table('categories')->insert([
            [
                'id'         => '1',
                'position'   => '1',
                'image'      => NULL,
                'status'     => '1',
                '_lft'       => '1',
                '_rgt'       => '16',
                'parent_id'  => NULL,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id'         => '2',
                'position'   => '1',
                'image'      => NULL,
                'status'     => '1',
                '_lft'       => '14',
                '_rgt'       => '15',
                'parent_id'  => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ]
        ]);

        DB::table('category_translations')->insert([
            [
                'id'               => '1',
                'name'             => 'Root',
                'slug'             => 'root',
                'description'      => 'Root',
                'meta_title'       => '',
                'meta_description' => '',
                'meta_keywords'    => '',
                'category_id'      => '1',
                'locale'           => 'en',
            ],
            [
                'id'               => '2',
                'name'             => 'Category 1',
                'slug'             => 'category-1',
                'description'      => 'Category 1',
                'meta_title'       => '',
                'meta_description' => '',
                'meta_keywords'    => '',
                'category_id'      => '2',
                'locale'           => 'en',
            ]
        ]);
    }
}