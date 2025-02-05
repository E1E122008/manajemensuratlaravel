<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('sppd_attachments')) {
            Schema::create('sppd_attachments', function (Blueprint $table) {
                $table->id();
                $table->foreignId('sppd_id')->constrained()->onDelete('cascade');
                $table->string('file_path');
                $table->string('file_name');
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('sppd_attachments');
    }
}; 