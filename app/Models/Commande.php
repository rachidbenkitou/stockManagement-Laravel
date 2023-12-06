<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    use HasFactory;

    // Les colonnes pouvant être remplies massivement
    protected $fillable = ['date_commande', 'prix', 'client_id', 'orderStatus_id', 'discount_id'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    public function orderStatus()
    {
        return $this->belongsTo(OrderStatus::class, 'orderStatus_id');
    }
    public function discount()
    {
        return $this->belongsTo(Discount::class, 'discount_id');
    }
    public function produits()
    {
        return $this->belongsToMany(Produit::class, 'commande_produit', 'produit_id', 'commande_id')
            ->withPivot('quantity', 'price');
    }
    public function factures()
    {
        return $this->belongsTo(Facture::class);
    }


}
