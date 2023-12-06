<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pack extends Model
{
    use HasFactory;
    // Les colonnes pouvant être remplies massivement
    protected $fillable = ['codePack','nbrProduits','disponible','prix'];
    public function produits(){
        return $this->belongsToMany(Produit::class, 'produit_pack')->withPivot( 'produit_id','pack_id', 'qte');

    }
}
