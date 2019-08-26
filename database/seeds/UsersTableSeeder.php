<?php

use App\Role;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::where('role_name', 'Super Admin')->first();

        $user = new User();
        $user->name = 'MoSHE Admin';
        $user->email = 'moshe@super.com';
        $user->password = Hash::make('00000000');

        $user->save();
        $user->roles()->attach($role);
    }
}
