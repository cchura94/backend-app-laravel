<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Categoria;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->limite){
            $productos = Producto::paginate($request->limite);
        }else{
            $productos = Producto::paginate(15);
        }
        return response()->json($productos, 200);
    }

    /*
    public function registrarAction() {
        $form = new Admin_Form_Usuario();
        if ($this->getRequest()->isPost()) {
            $form->usuario->addValidator(Admin_Model_Lib::validarRepeditosAdd('usuario', 'usuario', 'ya existe este nombre de usuario'));
            if ($form->isValid($this->_request->getPost())) {//validar los campos de formulario
                $db = Zend_Db_Table::getDefaultAdapter();
                $db->beginTransaction();
                try {

                    $model_usuario = new Admin_Model_Usuario();
                    $model_usuario->addUsuario($this->_request->getParams());
                    $db->commit();
                } catch (Exception $e) {
                    $db->rollBack();
                    echo $e->getMessage();
                }
            }
        }
        $this->view->form = $form;
    }
    */

    public function guardarProducto(Request $request)
    {
        $prod = new Producto;
        $prod->guardar($request);
        $cat = new Categoria;
        
        return ["mensaje", "Producto registrado"];
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
            "nombre" => "required|max:255|min:3|string",
            "categoria_id" => "required"
        ]);
        // subir la imagen
        $nom_img = "";
        if($file = $request->file("imagen")){
            // nombre original el archivo
            $nom_archivo = $file->getClientOriginalName();
            $file->move("imagenes/productos/", $nom_archivo);
            $nom_img = "imagenes/productos/" . $nom_archivo;

        }
        // guardar
        
        $producto = new Producto;
        $producto->nombre = $request->nombre;
        $producto->precio = $request->precio;
        $producto->stock = $request->stock;
        $producto->descripcion = $request->descripcion;
        $producto->imagen = $nom_img;
        $producto->categoria_id = $request->categoria_id;
        $producto->save();
        
        
        // $prod = Producto::create($request->all())
        //Producto::guardarProducto($request);
        
        // responder
        return response()->json(["mensaje" => "Producto Registrado","data" => $producto, "error"=> false ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $producto = Producto::find($id);
        return response()->json($producto, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
         // validar
         $request->validate([
            "nombre" => "required|max:255|min:3|string",
            "categoria_id" => "required"
        ]);
        // subir la imagen

        // guardar
        $nom_img = "";
        $producto = Producto::find($id);
        $producto->nombre = $request->nombre;
        $producto->precio = $request->precio;
        $producto->stock = $request->stock;
        $producto->descripcion = $request->descripcion;

        $nom_img = "";
        if($file = $request->file("imagen")){
            // nombre original el archivo
            $nom_archivo = $file->getClientOriginalName();
            $file->move("imagenes/productos/", $nom_archivo);
            $nom_img = "imagenes/productos/" . $nom_archivo;

            $producto->imagen = $nom_img;
        }
        
        $producto->categoria_id = $request->categoria_id;
        $producto->save();

        // responder
        return response()->json(["mensaje" => "Producto Modificado", "error"=> false ], 200);
   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $producto = Producto::find($id);
        $producto->delete();
        return response()->json(["mensaje" => "Producto Eliminado", "error"=> false ], 200);
   
    }
}
