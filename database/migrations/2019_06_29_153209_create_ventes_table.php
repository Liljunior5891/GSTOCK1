<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVentesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ventes', function (Blueprint $table) {
            $table->Increments('id');
            $table->String('numero')->default(null);
            $table->integer('client_id')->unsigned()->nullable()->index();
            $table->foreign('client_id')
                ->references('id')
                ->on('clients')
                ->onUpdate('cascade');
            $table->integer('user_id')->unsigned()->nullable()->index();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade');
            $table->dateTime('date_vente')->default(now());
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
        Schema::dropIfExists('ventes');
    }
}
