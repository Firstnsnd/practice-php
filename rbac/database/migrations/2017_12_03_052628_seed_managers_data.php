<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeedManagersData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      $managers = [
          [
              'username'  => 'manager',
              'password' => md5('manager'),
              'roleid'  => '1'
          ],
      ];

      DB::table('managers')->insert($managers);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('managers')->truncate();
    }
}
