<?php

namespace App\Models;

use App\Models\Commande;
use App\Models\Fournisseur;
use App\Models\Categorie;
use App\Models\Discount;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    use HasFactory;

    protected $fillable = ['code_produit', 'quantite', 'prix_unitaire', 'description', 'discount_id', 'categorie_id'];

    public function commandes()
    {
        return $this->belongsToMany(Commande::class, 'commande_produit', 'produit_id', 'commande_id')
            ->withPivot('quantity', 'price');
    }

    public function fournisseurs()
    {
        return $this->belongsToMany(Fournisseur::class, 'fournisseur_produit')->withPivot('fournisseur_id', 'produit_id', 'qte_entree', 'date_entree')
            ->withPivot('quantity', 'price');
    }
    public function packs()
    {
        return $this->belongsToMany(Pack::class, 'produit_pack')->withPivot( 'produit_id','pack_id', 'qte');
    }


    public function categorie(){
        return $this->belongsTo(Categorie::class);
    }
    public function discount(){
        return $this->belongsTo(Discount::class);
    }
}
