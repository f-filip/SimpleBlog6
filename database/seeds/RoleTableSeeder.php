<?php

use Illuminate\Database\Seeder;
use App\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_user = new Role();
        $role_user->name = 'user';
        $role_user->description = 'Regular user';
        $role_user->save();

        $admin_user = new Role();
        $admin_user->name = 'admin';
        $admin_user->description = 'Admin user';
        $admin_user->save();

        $author_user = new Role();
        $author_user->name = 'Author';
        $author_user->description = 'Author user';
        $author_user->save();


    }
}
