<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Personal extends Model
{
    use HasFactory, SoftDeletes;

    public function pedidos()
    {
        return $this->hasMany(Pedido::class);
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function persona()
    {
        return $this->hasOne(Persona::class);
    }

}
