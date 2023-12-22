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
            $fournisseur->produits()->syncWithPivotValues(
                $produits->random(rand(1, 5))->pluck('id')->toArray(),
                [
                    'qte_entree' => rand(1, 100),
                    'date_entree' => now(),
                ],
                false  // Utilisez 'false' pour ne pas détacher les autres produits
            );

            // Mettez à jour la quantité totale du produit
            foreach ($fournisseur->produits as $produit) {
                $produit->quantite += $produit->pivot->qte_entree;
                $produit->save();
            }
        }
    }
}
