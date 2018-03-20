<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeedRolesData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      $roles = [
          [
              'rolename'  => '超级管理员',
              'per_list' => '*',
          ],
          [
              'rolename'  => '权限管理员',
              'per_list' => '2,3,4,5',
          ],
          [
              'rolename'  => '角色管理员',
              'per_list' => '7,8,9,10',
          ],
          [
              'rolename'  => '商品管理员',
              'per_list' => '17,18,19,20',
          ],
          [
              'rolename'  => '订单管理员',
              'per_list' => '22,23,24,25',
          ],
      ];

      DB::table('roles')->insert($roles);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('roles')->truncate();
    }
}
