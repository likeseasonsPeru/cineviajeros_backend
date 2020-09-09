<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeliculasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('peliculas', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('translate')->nullable();
            $table->text('description');
            $table->string('duration');
            $table->string('img');
            $table->string('precio_min')->nullable();
            $table->boolean('comision')->default(false);
            $table->string('url_trailer')->nullable();
            $table->string('url_compra');
            $table->string('type_public')->nullable();
            $table->string('category');
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
        Schema::dropIfExists('peliculas');
    }
}
