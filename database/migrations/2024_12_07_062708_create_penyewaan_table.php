<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenyewaanTable extends Migration
{
    public function up()
    {
        Schema::create('penyewaan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('gedung_id');
            $table->text('detail_acara');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->boolean('confirmed_status')->default(false);
            $table->timestamps();

            $table->foreign('id_user')->references('id_user')->on('users');
            $table->foreign('gedung_id')->references('id')->on('gedung');
        });
    }

    public function down()
    {
        Schema::dropIfExists('penyewaan');
    }
};
