<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

public function up()
{
    if (!Schema::hasColumn('users', 'nomor_telepon')) {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nomor_telepon')->nullable();
        });
    }

    if (!Schema::hasColumn('users', 'alamat')) {
        Schema::table('users', function (Blueprint $table) {
            $table->string('alamat')->nullable();
        });
    }
}


};
