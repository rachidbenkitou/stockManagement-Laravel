<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    // Nom de la table associée au modèle
    protected $table = 'Client';

    // Les colonnes pouvant être remplies massivement
    protected $fillable = ['firstName','lastName','email','phone','adresse'];
    public function commandes()
    {
        return $this->hasMany(Commande::class);
    }

}
