<?php

use Illuminate\Database\Seeder;
use Kodeine\Acl\Models\Eloquent\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        factory(Role::class)->create();
        Role::firstOrCreate([
            'name' => 'Администратор',
            'slug' => 'admin',
            'description' => 'администратор системы'
        ])->assignPermission(['users', 'categories', 'documents']);

        Role::firstOrCreate([
            'name' => 'Модератор',
            'slug' => 'moder',
            'description' => 'модератор'
        ])->assignPermission(['categories', 'documents']);


    }
}
