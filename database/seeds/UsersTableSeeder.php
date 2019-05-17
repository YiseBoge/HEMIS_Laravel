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
        $role = Role::where('role_name', 'Admin')->first();

        $user = new User();
        $user->name = 'Admin User';
        $user->email = 'admin@admin.com';
        $user->password = Hash::make('00000000');
        $user->institution_name_id = 0;
        $user->instance_id = 0;

        $user->save();
        $user->roles()->attach($role);
    }
}
