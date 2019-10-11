<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class  CreatePreVentesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pre_ventes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->double('quantite');
            $table->dateTime('dateVente');

            $table->integer('commande_id')->unsigned()->index();
            $table->enum('flag_etat',['commande','en cours','termine','annule','encaisse'])->default('commande');
            $table->integer('facture_id')->unsigned()->index()->nullable();
            $table->integer('caisse_id')->unsigned()->index()->nullable();
            $table->integer('produit_id')->unsigned()->index()->nullable();



            $table->foreign('caisse_id')
                ->references('id')
                ->on('caisses');

            $table->foreign('produit_id')
                ->references('id')
                ->on('produits');



            $table->foreign('commande_id')
                ->references('id')
                ->on('commandes')
                ->onUpdate('cascade');

            $table->foreign('facture_id')
                ->references('id')
                ->on('factures')
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
        Schema::dropIfExists('pre_ventes');
    }
}
