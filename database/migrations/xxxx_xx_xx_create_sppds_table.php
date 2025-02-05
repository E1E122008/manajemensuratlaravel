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
            $table->date('tanggal');
            $table->string('perihal');
            $table->string('nomor_spt');
            $table->string('nama_yang_bertugas');
            $table->date('tanggal_berangkat');
            $table->date('tanggal_kembali');
            $table->enum('type', ['domestic', 'foreign'])->default('domestic');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('sppds');
    }
}; 