<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeedPermissionsData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      $permissions = [
          [
              'pid'  =>  '0',
              'pername'  => '权限管理',
              'mname' => '',
              'cname' => '',
              'aname' => '',
          ],
          [
              'pid'  =>  '1',
              'pername'  => '权限列表',
              'mname' => 'admin',
              'cname' => 'permission',
              'aname' => 'index',
          ],
          [
              'pid'  =>  '1',
              'pername'  => '权限添加',
              'mname' => 'admin',
              'cname' => 'permission',
              'aname' => 'create',
          ],
          [
              'pid'  =>  '1',
              'pername'  => '权限修改',
              'mname' => 'admin',
              'cname' => 'permission',
              'aname' => 'edit',
          ],
          [
              'pid'  =>  '1',
              'pername'  => '权限删除',
              'mname' => 'admin',
              'cname' => 'permission',
              'aname' => 'delete',
          ],
          [
              'pid'  =>  '0',
              'pername'  => '角色管理',
              'mname' => '',
              'cname' => '',
              'aname' => '',
          ],
          [
              'pid'  =>  '6',
              'pername'  => '角色列表',
              'mname' => 'admin',
              'cname' => 'role',
              'aname' => 'index',
          ],
          [
              'pid'  =>  '6',
              'pername'  => '角色添加',
              'mname' => 'admin',
              'cname' => 'role',
              'aname' => 'create',
          ],
          [
              'pid'  =>  '6',
              'pername'  => '角色修改',
              'mname' => 'admin',
              'cname' => 'role',
              'aname' => 'edit',
          ],
          [
              'pid'  =>  '6',
              'pername'  => '角色删除',
              'mname' => 'admin',
              'cname' => 'role',
              'aname' => 'delete',
          ],
          [
              'pid'  =>  '0',
              'pername'  => '管理员管理',
              'mname' => '',
              'cname' => '',
              'aname' => '',
          ],
          [
              'pid'  =>  '11',
              'pername'  => '管理员列表',
              'mname' => 'admin',
              'cname' => 'manager',
              'aname' => 'index',
          ],
          [
              'pid'  =>  '11',
              'pername'  => '管理员添加',
              'mname' => 'admin',
              'cname' => 'manager',
              'aname' => 'create',
          ],
          [
              'pid'  =>  '11',
              'pername'  => '管理员修改',
              'mname' => 'admin',
              'cname' => 'manager',
              'aname' => 'edit',
          ],
          [
              'pid'  =>  '11',
              'pername'  => '管理员删除',
              'mname' => 'admin',
              'cname' => 'manager',
              'aname' => 'delete',
          ],
          [
              'pid'  =>  '0',
              'pername'  => '商品管理',
              'mname' => '',
              'cname' => '',
              'aname' => '',
          ],
          [
              'pid'  =>  '16',
              'pername'  => '商品列表',
              'mname' => 'admin',
              'cname' => 'product',
              'aname' => 'index',
          ],
          [
              'pid'  =>  '16',
              'pername'  => '商品添加',
              'mname' => 'admin',
              'cname' => 'product',
              'aname' => 'create',
          ],
          [
              'pid'  =>  '16',
              'pername'  => '商品修改',
              'mname' => 'admin',
              'cname' => 'product',
              'aname' => 'edit',
          ],
          [
              'pid'  =>  '16',
              'pername'  => '商品删除',
              'mname' => 'admin',
              'cname' => 'product',
              'aname' => 'delete',
          ],
          [
              'pid'  =>  '0',
              'pername'  => '订单管理',
              'mname' => '',
              'cname' => '',
              'aname' => '',
          ],
          [
              'pid'  =>  '21',
              'pername'  => '订单列表',
              'mname' => 'admin',
              'cname' => 'order',
              'aname' => 'index',
          ],
          [
              'pid'  =>  '21',
              'pername'  => '订单添加',
              'mname' => 'admin',
              'cname' => 'order',
              'aname' => 'create',
          ],
          [
              'pid'  =>  '21',
              'pername'  => '订单修改',
              'mname' => 'admin',
              'cname' => 'order',
              'aname' => 'edit',
          ],
          [
              'pid'  =>  '21',
              'pername'  => '订单删除',
              'mname' => 'admin',
              'cname' => 'order',
              'aname' => 'delete',
          ],

      ];

      DB::table('permissions')->insert($permissions);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('permissions')->truncate();
    }
}
