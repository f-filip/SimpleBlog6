<?php

use Illuminate\Database\Seeder;
use App\Role;
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
        $role_user = Role::where('name','user')->first();
        $role_admin = Role::where('name','admin')->first();
        $role_author = Role::where('name','author')->first();

        $user = new User;
        $user->name="UserName";
        $user->email="user@example.com";
        $user->password=Hash::make('password');
        $user->save();
        $user->roles()->attach($role_user);

        $admin = new User;
        $admin->name="adminName";
        $admin->email="admin@example.com";
        $admin->password=Hash::make('password');
        $admin->save();
        $admin->roles()->attach($role_admin);

        $author = new User;
        $author->name="authorName";
        $author->email="author@example.com";
        $author->password=Hash::make('password');
        $author->save();
        $author->roles()->attach($role_author);

    }
}
