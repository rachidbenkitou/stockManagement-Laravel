<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommandePackage extends Model
{
    use HasFactory;
    protected $fillable = ['pack_command_id', 'client_id', 'price'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function pack()
    {
        return $this->belongsTo(Pack::class);
    }

}
