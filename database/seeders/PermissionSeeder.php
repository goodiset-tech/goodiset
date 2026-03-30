<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        // Truncate the permissions table to clean it before seeding
        DB::table('permissions')->truncate();

        $modules = [
            'dashborad',
            'category',
            'brands',
            'products',
            'product_attributes',
            'theme',
            'flavours',
            'product_type',
            'basket_type',
            'package_type',
            'allergen',
            'ingredients',
            'size',
            'color',
            'pages',
            'orders',
            'reviews',
            'sliders',
            'user_management',
            'faqs',
            'newsletters',
            'settings',
            'blogs',
            'blog_category',
            'messages',
            'currency',
            'announcement',
            'vat',
            'subcategory'
        ];

        foreach ($modules as $module) {
            foreach (['create', 'read', 'update', 'delete'] as $action) {
                Permission::create([
                    'module_name' => $module,
                    'name' => ucfirst($action) . ' ' . ucfirst($module),
                    'action' => $action,
                ]);
            }
        }
    }
}
