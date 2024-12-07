<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGedungTable extends Migration
{
    public function up()
    {
        Schema::create('gedung', function (Blueprint $table) {
            $table->id();
            $table->string('nama_gedung');
            $table->string('deskripsi');
            $table->integer('kapasitas');
            $table->string('fasilitas');
            $table->string('alamat');
            $table->decimal('harga_internal', 10, 2);
            $table->decimal('harga_eksternal', 10, 2);
            $table->boolean('is_available');
            $table->string('gambar_gedung');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('gedung');
    }
};
