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
        Schema::create('produit_pack', function (Blueprint $table) {
            $table->id();
            $table->unsignedBiginteger('pack_id');
            $table->foreign('pack_id')->references('id')
                ->on('packs')->onDelete('cascade');
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
        Schema::dropIfExists('produit_pack');
    }
};
