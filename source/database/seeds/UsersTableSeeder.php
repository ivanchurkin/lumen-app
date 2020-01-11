<?php

use App\User;
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
        $administrator = new User();
        $administrator->name = 'Administrator';
        $administrator->email = 'admin@mail.com';
        $administrator->password = app('hash')->make('secret');
        $administrator->save();

        $manager = new User();
        $manager->name = 'Manager';
        $manager->email = 'manager@mail.com';
        $manager->password = app('hash')->make('secret');
        $manager->save();
    }
}
