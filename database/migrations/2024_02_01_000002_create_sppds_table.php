<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('sppds', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_sppd')->unique();
            $table->date('tanggal');
            $table->foreignId('pegawai_id')->constrained('employees');
            $table->string('tujuan');
            $table->text('keperluan');
            $table->date('tanggal_berangkat');
            $table->date('tanggal_kembali');
            $table->enum('type', ['domestic', 'foreign'])->default('domestic');
            $table->string('status')->default('draft');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sppds');
    }
}; 