<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommandePackage extends Model
{
    use HasFactory;
    protected $fillable = ['pack_id', 'client_id', 'price'];

//    public function commande()
//    {
//        return $this->belongsTo(Commande::class);
//    }
//
//    public function pack()
//    {
//        return $this->belongsTo(Pack::class);
//    }

}
