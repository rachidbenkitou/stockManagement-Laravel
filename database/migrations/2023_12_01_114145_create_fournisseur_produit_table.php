<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fournisseur_produit', function (Blueprint $table) {
            $table->id();
            $table->integer('qte_entree');
            $table->date('date_entree');
            $table->unsignedBiginteger('fournisseur_id');
            $table->foreign('fournisseur_id')->references('id')
                ->on('fournisseurs')->onDelete('cascade');
            $table->unsignedBiginteger('produit_id');
            $table->foreign('produit_id')->references('id')
                ->on('produits')->onDelete('cascade');
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
        Schema::dropIfExists('fournisseur_produit');
    }
};
