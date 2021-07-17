<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pedido extends Model
{
    use HasFactory, SoftDeletes;

    public function productos()
    {
        return $this->belongsToMany(Producto::class);
    }

    // cliente
    public function persona()
    {
        return $this->belongsTo(Persona::class);
    }

    public function personal()
    {
        return $this->belongsTo(Personal::class);
    }
}
