<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('sppds', function (Blueprint $table) {
            // Tambahkan kolom baru jika belum ada
            if (!Schema::hasColumn('sppds', 'perihal')) {
                $table->string('perihal')->after('tanggal')->nullable();
            }
            if (!Schema::hasColumn('sppds', 'nomor_spt')) {
                $table->string('nomor_spt')->after('perihal')->nullable();
            }
            if (!Schema::hasColumn('sppds', 'nama_yang_bertugas')) {
                $table->string('nama_yang_bertugas')->after('nomor_spt')->nullable();
            }
            if (!Schema::hasColumn('sppds', 'type')) {
                $table->enum('type', ['domestic', 'foreign'])->default('domestic')->after('tanggal_kembali');
            }
            if (!Schema::hasColumn('sppds', 'created_by')) {
                $table->unsignedBigInteger('created_by')->nullable();
                $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            }
            if (!Schema::hasColumn('sppds', 'updated_by')) {
                $table->unsignedBigInteger('updated_by')->nullable();
                $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
            }
        });
    }

    public function down()
    {
        Schema::table('sppds', function (Blueprint $table) {
            // Hapus kolom jika perlu rollback
            $table->dropForeign(['created_by']);
            $table->dropForeign(['updated_by']);
            $table->dropColumn([
                'perihal',
                'nomor_spt',
                'nama_yang_bertugas',
                'type',
                'created_by',
                'updated_by'
            ]);
        });
    }
}; 