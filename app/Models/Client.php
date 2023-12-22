<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Client extends Model
{
    use HasFactory, HasApiTokens; // Add this line for Sanctum or Passport

    // Nom de la table associée au modèle
    protected $table = 'Client';

    // Les colonnes pouvant être remplies massivement
    protected $fillable = ['firstName','lastName','email','phone','password', 'adresse'];
    public function commandes()
    {
        return $this->hasMany(Commande::class);
    }

}
