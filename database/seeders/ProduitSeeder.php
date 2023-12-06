<?php

namespace Database\Seeders;

use App\Models\Categorie;
use App\Models\Produit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class ProduitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('commande_produit')->truncate();
        DB::table('fournisseur_produit')->truncate();
        DB::table('produits')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $categories = Categorie::all();
        $faker = Faker::create();
        $numberOfRecords= 50;
        for ($i = 0; $i < $numberOfRecords; $i++) {
            $produit = Produit::create([
                'code_produit' => $faker->unique()->ean13,
                'quantite' => $faker->numberBetween(5, 100),
                'prix_unitaire' => $faker->randomFloat(2, 10, 100),
                'description' => $faker->sentence,
            ]);
            $produit->categorie()->associate($categories->random());
            $produit->save();
        }
    }
}
