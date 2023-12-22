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
        Schema::create('produits', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('image');
            $table->string('code_produit');
            $table->integer('quantite');
            $table->double('prix_unitaire');
            $table->string('description');
            $table->unsignedBigInteger('categorie_id')->nullable()->default(null);
            $table->foreign('categorie_id')->references('id')
                ->on('categories')->onDelete('cascade');
            $table->unsignedBigInteger('discount_id')->nullable()->default(null);
            $table->foreign('discount_id')->references('id')
                ->on('discounts')->onDelete('cascade');
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
        Schema::dropIfExists('produits');
    }
};
