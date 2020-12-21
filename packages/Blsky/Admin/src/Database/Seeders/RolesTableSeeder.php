<?php

namespace Blsky\Admin\Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Webkul\User\Models\Role;

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('admins')->delete();

        DB::table('roles')->delete();

        DB::table('roles')->insert(
            [
                'id'              => 1,
                'name'            => 'Administrator',
                'description'     => 'Administrator rolem',
                'permission_type' => 'all',
            ],
        );
        DB::table('roles')->insert(
            [
                'id'              => 2,
                'name'            => 'User',
                'description'     => 'User Role',
                'permissions'      => '["dashboard","sales","sales.orders","sales.invoices","sales.shipments","catalog","catalog.products","catalog.products.create","catalog.products.edit","catalog.products.delete","catalog.categories","catalog.categories.create","catalog.categories.edit","catalog.categories.delete","customers","customers.customers","customers.customers.create","customers.customers.edit","customers.customers.delete","customers.groups","customers.groups.create","customers.groups.edit","customers.groups.delete","customers.reviews","customers.reviews.edit","customers.reviews.delete","promotions","promotions.cart-rules","promotions.cart-rules.create","promotions.cart-rules.edit","promotions.cart-rules.delete","promotions.catalog-rules","promotions.catalog-rules.create","promotions.catalog-rules.edit","promotions.catalog-rules.delete"]',
                'permission_type' => 'custom',
            ]
        );
    }
}
