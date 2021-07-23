<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Persona extends Model
{
    use HasFactory, SoftDeletes;

    public function pedidos()
    {
        return $this->hasMany(Pedido::class);
    }

    public function personal()
    {
        return $this->belongsTo(Personal::class);
    }

}
