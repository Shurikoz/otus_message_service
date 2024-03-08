<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    const TABLE = 'users';

    public function up()
    {
        Schema::table(self::TABLE, function (Blueprint $table) {
            $table->dropColumn('name');
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->date('birthday');
            $table->boolean('sex');
            $table->string('interests', 200);
            $table->string('city', 50);
        });
    }

    public function down()
    {
        Schema::table(self::TABLE, function (Blueprint $table) {
            $table->dropColumn('first_name');
            $table->dropColumn('last_name');
            $table->dropColumn('birthday');
            $table->dropColumn('sex');
            $table->dropColumn('interests');
            $table->dropColumn('city');
        });
    }
};
