<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClient extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mu_client', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->string('razon_social');
            $table->double('latitud',15,8);
            $table->double('longitud',15,8);
            $table->boolean('active')->default(true);
            $table->softDeletes();
            $table->rememberToken();
            $table->timestamps(); //create_at , update_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('mu_client');
    }
}
