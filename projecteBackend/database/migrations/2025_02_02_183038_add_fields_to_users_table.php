<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('surnames');
            $table->string('phone')->nullable();
            $table->date('hireDate');
            $table->date('terminationDate')->nullable();
            $table->string('username')->unique();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('surnames');
            $table->dropColumn('phone');
            $table->dropColumn('hireDate');
            $table->dropColumn('terminationDate');
            $table->dropColumn('username');
        });
    }
}
