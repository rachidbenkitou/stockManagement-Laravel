<?php

namespace App\Models;
use App\Models\Produit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fournisseur extends Model
{
    use HasFactory;

    protected $fillable = ['code_fournisseur','nom','adresse','tel','mail','fax'];

    public function produits(){
        return $this->belongsToMany(Produit::class, 'fournisseur_produit')->withPivot('fournisseur_id', 'produit_id', 'qte_entree', 'date_entree');
        
    }
}
