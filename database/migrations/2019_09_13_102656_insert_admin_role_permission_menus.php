<?php

use Illuminate\Database\Migrations\Migration;
use Encore\Admin\Auth\Database\Menu;
use Encore\Admin\Auth\Database\Role;
use Encore\Admin\Auth\Database\Administrator;
use Encore\Admin\Auth\Database\Permission;
use Carbon\Carbon;

class InsertAdminRolePermissionMenus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $now = Carbon::now();
        // create a user.
        $admin = new Administrator();
        $admin->username = 'admin';
        $admin->password = bcrypt('>@a6SMm?{#]N!4r8');
        $admin->name = 'Admin';
        $admin->save();

        // create a role.
        Role::create([
            'name' => 'Administrator',
            'slug' => 'administrator',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // add role to users.
        Administrator::whereusername('admin')->first()->roles()->save(Role::first());

        //create a permission
        Permission::insert([
            [
                'name'        => 'All permission',
                'slug'        => '*',
                'http_method' => '',
                'http_path'   => '*',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name'        => 'Dashboard',
                'slug'        => 'dashboard',
                'http_method' => 'GET',
                'http_path'   => '/',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name'        => 'Login',
                'slug'        => 'auth.login',
                'http_method' => '',
                'http_path'   => "/auth/login\r\n/auth/logout",
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name'        => 'User setting',
                'slug'        => 'auth.setting',
                'http_method' => 'GET,PUT',
                'http_path'   => '/auth/setting',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name'        => 'Auth management',
                'slug'        => 'auth.management',
                'http_method' => '',
                'http_path'   => "/auth/roles\r\n/auth/permissions\r\n/auth/menu\r\n/auth/logs",
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);

        Role::first()->permissions()->save(Permission::first());

        // add default menus.
        Menu::insert([
            [
                'parent_id' => 0,
                'order'     => 1,
                'title'     => 'Images',
                'icon'      => 'fa-list',
                'uri'       => '/images',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);

        // add role to menu.
        Menu::find(1)->roles()->save(Role::first());
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Menu::truncate();
        Permission::truncate();
        Role::truncate();
        Administrator::truncate();
    }
}