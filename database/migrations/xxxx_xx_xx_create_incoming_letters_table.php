<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('incoming_letters', function (Blueprint $table) {
            $table->id();
            $table->string('reference_number');
            $table->string('from');
            $table->string('agenda_number');
            $table->date('letter_date');
            $table->date('received_date');
            $table->text('description');
            $table->string('classification_code');
            $table->string('note')->nullable();
            $table->timestamps();

            $table->foreign('classification_code')
                  ->references('code')
                  ->on('classifications')
                  ->onDelete('restrict');
        });
    }

    public function down()
    {
        Schema::dropIfExists('incoming_letters');
    }
}; 