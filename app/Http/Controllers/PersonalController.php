<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Personal;
use App\Models\Persona;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PersonalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $personal = Personal::all();
        foreach ($personal as $p) {
            $p->persona;
            $p->user;
        }
        return response()->json($personal);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validar
        $request->validate([
            "nombres" => "required|string|max:50",
            "apellidos" => "required|string|max:50",
            "ci_nit" => "required|max:15|unique:personas",
            "email" => "required|email|unique:users",
            "password" => "required|max:50",
            "item" => "required",
        ]);
        // persona_id
        $p = new Persona;
        $p->nombres = $request->nombres;
        $p->apellidos = $request->apellidos;
        $p->ci_nit = $request->ci_nit;
        $p->telefono = $request->telefono;
        $p->save(); // $p->id

        // user_id
        $u = new User;
        $u->name = $request->nombres;
        $u->email = $request->email;        
        $u->password = bcrypt($request->password);
        $u->save();

        // personal
        $personal = new Personal;
        $personal->persona_id = $p->id;
        $personal->user_id = $u->id;
        $personal->item = $request->item;
        $personal->save();

        return response()->json([
            "mensaje" => "Personal Creado correctamente",
            "error" => false
        ], 201);
    }

    /*public function nuevoPersonal(Type $var = null)
    {
        # code...
    }
    */

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $personal = Personal::find($id);
        $personal->persona;
        $personal->user;
        
        return response()->json($personal);
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
        
        $personal = Personal::find($id);

        // validar
        $request->validate([
            "nombres" => "required|string|max:100",
            "apellidos" => "required|string|max:100",
            "ci_nit" => "required|max:15",
            "email" => "required|email|unique:users,email,".$personal->user->id,
            // "password" => "required|max:50",
            "item" => "required",
        ]);

        
        // persona_id
        $p = Persona::find($personal->persona_id);
        $p->nombres = $request->nombres;
        $p->apellidos = $request->apellidos;
        $p->ci_nit = $request->ci_nit;
        $p->telefono = $request->telefono;
        $p->save(); // $p->id

        // user_id
        $u = User::find($personal->user_id);
        $u->name = $request->nombres;
        $u->email = $request->email;  

        if($request->password){
            $u->password = bcrypt($request->password);
        }      
        $u->save();

        // personal
        $personal->item = $request->item;
        $personal->save();

        return response()->json([
            "mensaje" => "Personal Modificado correctamente",
            "error" => false
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $personal = Personal::find($id);
        $personal->delete();

        return response()->json([
            "mensaje" => "Personal eliminado correctamente",
            "error" => false
        ], 200);
    }
}
