<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;
    protected $fillable = ['type', 'description', 'percentage', 'price'];
    public function commandes()
    {
        return $this->belongsToMany(Commande::class);
    }
}
