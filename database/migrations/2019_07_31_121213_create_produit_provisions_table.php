<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProduitProvisionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produit_provisions', function (Blueprint $table) {
            $table->Increments('id');
           ;$table->integer('quantite');
            $table->double('prixAchat');

            $table->dateTime('date_prelivraison');
            $table->dateTime('date_livraison')->nullable();
            $table->integer('produit_id')->unsigned()->index();
            $table->integer('provision_id')->unsigned()->index();
            $table->boolean('flag_etat')->default(false);
            $table->boolean('flag_supp')->default(false);
            $table->foreign('produit_id')
                ->references('id')
                ->on('produits')
                ->onUpdate('cascade');

            $table->foreign('provision_id')
                ->references('id')
                ->on('provisions')
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
        Schema::dropIfExists('produit_provisions');
    }
}
