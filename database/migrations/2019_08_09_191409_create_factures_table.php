<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('factures', function (Blueprint $table) {
            $table->Increments('id');
            $table->date('dateExp');
            $table->double('reliquat')->default(0);
            $table->double('sommeDonnee');
            $table->integer('typePaiement_id')->unsigned()->index();

            $table->foreign('typePaiement_id')
                ->references('id')
                ->on('type_paiements');
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
        Schema::dropIfExists('factures');
    }
}
