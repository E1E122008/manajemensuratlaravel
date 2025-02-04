<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('spts', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_spt')->unique();
            $table->date('tanggal');
            $table->foreignId('pegawai_id')->constrained('employees');
            $table->string('tujuan');
            $table->text('keperluan');
            $table->enum('type', ['domestic', 'foreign']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('spts');
    }
}; 