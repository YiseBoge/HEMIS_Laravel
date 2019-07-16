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
        $user->name = 'Super Admin';
        $user->email = 'admin@admin.com';
        $user->password = Hash::make('00000000');
        $user->instance_id = 0;
        $user->institution_name_id = 0;
        $user->band_name_id = 0;
        $user->college_name_id = 0;
        $user->department_name_id = 0;

        $user->save();
        $user->roles()->attach($role);
    }
}
