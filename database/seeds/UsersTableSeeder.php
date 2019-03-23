<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('users')->delete();
       
        factory(App\User::class, 1)->create(['email' => 'demo1@example.com']);
        factory(App\User::class, 1)->create(['email' => 'demo2@example.com']);
    }
}
