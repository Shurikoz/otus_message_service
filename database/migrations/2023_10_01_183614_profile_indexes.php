<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('profiles', function ($table) {
            $table->index(['first_name', 'last_name']);
//            $table->index(['first_name']);
//            $table->index(['last_name']);
        });
    }

    public function down(): void
    {
        Schema::table('profiles', function ($table) {
            $table->dropIndex(['first_name', 'last_name']);
//            $table->dropIndex(['first_name']);
//            $table->dropIndex(['last_name']);
        });
    }
};
