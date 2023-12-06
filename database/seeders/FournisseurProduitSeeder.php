<?php

namespace Database\Seeders;

use App\Models\Fournisseur;
use App\Models\Produit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FournisseurProduitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fournisseurs = Fournisseur::all();
        $produits = Produit::all();

        // Attacher des produits à des fournisseurs
        foreach ($fournisseurs as $fournisseur) {
            $fournisseur->produits()->attach(
                $produits->random(rand(1, 5))->pluck('id')->toArray(),
                [
                    'qte_entree' => rand(1, 100),
                    'date_entree' => now(),
                ]
            );
        }
    }
}
