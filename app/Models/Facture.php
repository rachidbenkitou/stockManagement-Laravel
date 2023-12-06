<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facture extends Model
{
    use HasFactory;


    // Les colonnes pouvant être remplies massivement
    protected $fillable = ['codeFacture','dateFacturation','total','datePaiement','modePaiement'];
    public function commande()
    {
        return $this->belongsTo(Commande::class);
    }
}
