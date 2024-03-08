<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;


class CompanieController extends Controller
{
    
    public function list(){
        $companies = Company::all();
        $list = [];

        foreach($companies as $company){
            $object = [
                "id" => $company->id,
                "name" => $company->name,
                "direction" => $company->direction,
                "phone" => $company->phone,
                "created_at" => $company->created_at,
                "updated_at" => $company->updated_at,
            ];

            array_push($list, $object);
        }

        return response()->json($list);
    }

    public function item($id){
            $companies = Company::where('id', '=', $id)->first();
                $object = [
                    "id" => $companies->id,
                    "name" => $companies->name,
                    "direction" => $companies->direction,
                    "phone" => $companies->phone,
                    "created_at" => $companies->created_at,
                    "updated_at" => $companies->updated_at,
                ];
            return response()->json($object);
    }

    public function update(Request $request){
        $data = $request -> validate([
            'id' => 'required|numeric',
            'name' => 'required|min:3',
            'direction' => 'required|min:3',
            'phone' => 'required|min:3'
        ]);
   
        $company = Company::where('id', '=', $data['id'])->first();

        if($company) {
            $old = clone $company;

            $company -> name = $data['name'];
            $company -> direction = $data['direction'];
            $company -> phone = $data['phone'];

            if($company->save()){
                return response() ->json([
                    'message' => 'Compañia actualizado correctamente',
                    'old' => $old,
                    'new' => $company
                ]);
            }else{
                return response() ->json([
                    'message' => 'Error al actualizar una compañia',
                ]);
            }
        }else{
            return response() ->json([
                'message' => 'Elemento no encontrado',
            ]);
        }
    }

    public function create(Request $request){
        $data = $request -> validate([
            'name' => 'required|min:3',
            'direction' => 'required|min:3',
            'phone' => 'required|min:3'
        ]);

       $company = Company::create([
            'name' => $data['name'],
            'direction' => $data['direction'],
            'phone' => $data['phone']
        ]);

        if($company) {
            return response() ->json([
                'message' => 'Compañía creada correctamente',
                'data' => $company
            ]);

        }else{
            return response() ->json([
                'message' => 'Error al crear un compañia',
            ]);
        }
    }
}
