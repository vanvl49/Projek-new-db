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
            $table->enum('confirmed_status', ['pending', 'confirmed', 'rejected'])->default('pending');
            $table->timestamps();

            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
            $table->foreign('gedung_id')->references('id')->on('gedung')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('penyewaan');
    }
};
