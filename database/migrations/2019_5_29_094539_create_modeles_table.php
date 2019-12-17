<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModelesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modeles', function (Blueprint $table) {
            $table->Increments('id');
            $table->String('libelle');
            $table->String('numero')->default(null);
            $table->integer('quantite');
            $table->integer('prix');
            $table->integer('seuil')->default(1);
            $table->integer('produit_id')->unsigned()->nullable()->index();
            $table->foreign('produit_id')
                ->references('id')
                ->on('produits')
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
        Schema::dropIfExists('modeles');
    }
}
