<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClaimedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('claimeds', function (Blueprint $table) {
            $table->id();
            $table->string('names')->nullable();
            $table->string('surnames')->nullable();
            $table->string('type_document')->nullable();
            $table->string('n_document')->nullable();
            $table->string('home')->nullable();
            $table->string('district')->nullable();
            $table->string('telephone')->nullable();
            $table->string('email')->nullable();
            $table->string('type_claim')->nullable();
            $table->string('date')->nullable();
            $table->string('n_ticket')->nullable();
            $table->string('monto')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('claimeds');
    }
}
