<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategorieController extends Controller
{
    //
    public function list(){
        $categories = Category::all();
        $list = [];

        foreach($categories as $category){
            $object = [
                "id" => $category->id,
                "name" => $category->name,
                "created_at" => $category->created_at,
                "updated_at" => $category->updated_at,
            ];
            
            array_push($list, $object);
        }

        return response()->json($list);
    }

    public function item($id){
            $category = Category::where('id', '=', $id)->first();
                $object = [
                    "id" => $category->id,
                    "name" => $category->name,
                    "created_at" => $category->created_at,
                    "updated_at" => $category->updated_at,
                ];
            return response()->json($object);
    }

    public function create(Request $request){
        $data = $request -> validate([
            'name' => 'required|min:3',
        ]);

       $category= Category::create([
            'name' => $data['name']
        ]);

        if($category) {
            return response() ->json([
                'message' => 'Compañía creada correctamente',
                'data' => $category
            ]);

        }else{
            return response() ->json([
                'message' => 'Error al crear un compañia',
            ]);
        }
    }

    public function update(Request $request){
        $data = $request -> validate([
            'id' => 'required|numeric',
            'name' => 'required|min:3',
        ]);
   
        $categories = Category::where('id', '=', $data['id'])->first();

        if($categories) {
            $old = clone $categories;

            $categories -> name = $data['name'];

            if($categories->save()){
                return response() ->json([
                    'message' => 'Categoria Actualizada correctamente',
                    'old' => $old,
                    'new' => $categories
                ]);
            }else{
                return response() ->json([
                    'message' => 'Error al actualizar',
                ]);
            }
        }else{
            return response() ->json([
                'message' => 'Elemento no encontrado',
            ]);
        }
    }
}
