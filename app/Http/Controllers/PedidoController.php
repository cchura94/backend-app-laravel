<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pedido;

class PedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Pedido::paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // persona (cliente)
        $cliente_id = $request->cliente_id;
        // personal ()
        $personal_id = Auth::user()->personal->id;
        // pedido
        $pedido = new Pedido;
        $pedido->fecha_pedido = date('Y-m-d H:i:s');
        $pedido->estado = 0;
        $pedido->cod_factura = $request->cod_factura;
        $pedido->persona_id = $cliente_id;
        $pedido->personal_id = $personal_id;
        $pedido->save();
        // N:M
        // Add productos al pedido
        /*
        carrito: {
            productos: [
                {producto_id: 3, cantidad: 1},
                {producto_id: 5, cantidad: 3}
            ],
            monto_total: 100,            
        }        
        */
        $productos = $request->carrito["productos"];
        foreach ($productos as $prod) {
            $pedido->productos()->attach($prod["producto_id"], ['cantidad' => $prod["cantidad"]]); 
        }

        $pedido->estado = 1;
        $pedido->save();

        return response()->json(["mensaje" => "Pedido registrado", "pedido" => $pedido]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pedido = Pedido::find($id);
        $pedido->productos;
        $pedido->persona;
        $pedido->personal;
        $pedido->personal->persona;
        $pedido->personal->user;
        return response()->json($pedido);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
