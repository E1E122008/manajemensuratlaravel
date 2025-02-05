<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('employees', function (Blueprint $table) {
            // Ubah kolom yang ada menjadi nullable
            $table->string('nip')->nullable()->change();
            $table->string('jabatan')->nullable()->change();
            $table->string('pangkat')->nullable()->change();
            $table->string('golongan')->nullable()->change();
            $table->string('unit_kerja')->nullable()->change();
            $table->unsignedBigInteger('created_by')->nullable()->change();
            $table->unsignedBigInteger('updated_by')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('employees', function (Blueprint $table) {
            // Kembalikan kolom menjadi required
            $table->string('nip')->nullable(false)->change();
            $table->string('jabatan')->nullable(false)->change();
            $table->string('pangkat')->nullable(false)->change();
            $table->string('golongan')->nullable(false)->change();
            $table->string('unit_kerja')->nullable(false)->change();
            $table->unsignedBigInteger('created_by')->nullable(false)->change();
            $table->unsignedBigInteger('updated_by')->nullable(false)->change();
        });
    }
}; 