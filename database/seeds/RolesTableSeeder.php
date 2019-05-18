<?php

use App\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $allRoles = ['Super Admin', 'Admin', 'Editor', 'Viewer'];

        foreach ($allRoles as $role) {
            $userRole = new Role();
            $userRole->role_name = $role;

            $userRole->save();
        }
    }
}
