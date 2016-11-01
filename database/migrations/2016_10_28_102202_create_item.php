<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mu_item', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->decimal('precio',8,2);
            $table->integer('stock');
            $table->integer('category_id')->unsigned();
            //$table->foreign('category_id')->references('id')->on('Category')->onDelete('cascade');
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
        Schema::drop('mu_item');
    }
}
