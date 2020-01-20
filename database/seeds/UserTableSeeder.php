<?php

use Illuminate\Database\Seeder;
use App\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        factory(User::class, 20)->create();
        User::create([
            'login' => 'admin',
            'email' => 'kaluga_edu@admin.ru',
            'password' => 'kaluga'
        ])->assignRole('admin');
    }
}
