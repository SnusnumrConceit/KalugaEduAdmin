<?php

use Illuminate\Database\Seeder;
use \Illuminate\Support\Facades\DB;
use \Kodeine\Acl\Models\Eloquent\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::firstOrCreate([
            'name' => 'categories',
            'slug' => [
                'create'     => true,
                'view'       => true,
                'update'     => true,
                'delete'     => true
            ],
            'description' => 'модуль категории'
        ]);

        Permission::firstOrCreate([
            'name' => 'documents',
            'slug' => [
                'create'     => true,
                'view'       => true,
                'update'     => true,
                'delete'     => true
            ],
            'description' => 'модуль документов'
        ]);

        Permission::firstOrCreate([
            'name' => 'users',
            'slug' => [
                'create'     => true,
                'view'       => true,
                'update'     => true,
                'delete'     => true
            ],
            'description' => 'модуль пользователей'
        ]);
    }
}
