<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Producto extends Model
{
    use HasFactory, SoftDeletes;

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function pedidos()
    {
        // Relación entre Producto con pedidos (N:M) 
        // indicando el nombre de la tabla relación pedido_productos
        return $this->belongsToMany(Pedido::class, "pedido_productos");
    }

    /**
     * Esta función me permite guardar datos de
     * productos en la base de datos
     */
    public function guardar($datos)
    {
        $this->nombre = $datos->nombre;
        $this->precio = $datos->precio;
        $this->categoria_id = $datos->categoria_id;
        $this->save();
    }

    /*
    protected $fillable = [
        'nombre',
        'precio',
        'stock',
    ];*/
    /*
    public function addUsuario($datos) {

        $data = array(
            'nombre_usuario' => $datos['nombre_usuario'],
            'usuario' => $datos['usuario'],
            'clave' => $datos['clave'],
            'role' => $datos['role'],
            'estado_usuario' => 'ACTIVO',
            'usuario_registrado_fecha' => date('Y-m-d'),
            'usuario_modificado_fecha' => '0000-00-00',
            'usuario_registrado_hora' => date('H:i:s'),
            'usuario_modificado_hora' => '0000-0',
             'estado_usuario' => 'ACTIVO',
            'usuario_registrado_fecha' => date('Y-m-d'),
            'usuario_modificado_fecha' => '0000-00-00',
            'usuario_registrado_hora' => date('H:i:s'),
            'usuario_modificado_hora' => '0000-00-00',
        );

        $this->insert($data);
    }
    */
}
