<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReglementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reglements', function (Blueprint $table) {
            $table->Increments('id');
            $table->integer('montant_donne');
            $table->integer('montant_restant');
            $table->dateTime('date_reglement')->default(now());
            $table->integer('vente_id')->unsigned()->nullable()->index();
            $table->foreign('vente_id')
                ->references('id')
                ->on('ventes')
                ->onUpdate('cascade');
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
        Schema::dropIfExists('reglements');
    }
}
