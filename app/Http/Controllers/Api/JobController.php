<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Job;

class JobController extends Controller
{
    public function list(){
        $jobs = Job::all();
        $list = [];

        foreach($jobs as $job){
            $object = [
                "id" => $job->id,
                "salary"=> $job->salary,
                "description"=> $job->description,
                "address"=> $job->address,
                "requirements"=> $job->requirements,
                "date"=> $job->date,
                "created_at" => $job->created_at,
                "updated_at" => $job->updated_at,
            ];
            array_push($list, $object);
        }

        return response()->json($list);
    }

    public function item($id){
            $job = Job::where('id', '=', $id)->first();
                $object = [
                    "id" => $job->id,
                    "salary"=> $job->salary,
                    "description"=> $job->description,
                    "address"=> $job->address,
                    "requirements"=> $job->requirements,
                    "date"=> $job->date,
                    "created_at" => $job->created_at,
                    "updated_at" => $job->updated_at,
                ];
            return response()->json($object);
    }

    public function create(Request $request){
        $data = $request -> validate([
            'salary' => 'required|min:2',
            'description' => 'required|min:2',
            'address' => 'required|min:2',
            'requirements' => 'required|min:2',
            'date' => 'required|min:3'
        ]);

        $job = Job::create([
            'salary' => $data['salary'],
            'description' => $data['description'],
            'address' => $data['address'],
            'requirements' => $data['requirements'],
            'date' => $data['date']
        ]);

        if($job) {
            return response() ->json([
                'message' => 'Compañía creada correctamente',
                'data' => $job
            ]);

        }else{
            return response() ->json([
                'message' => 'Error al crear un trabajo',
            ]);
        }
    }

    public function update(Request $request){
        $data = $request -> validate([
            'id' => 'required|numeric',
            'salary' => 'required|min:2',
            'description' => 'required|min:2',
            'address' => 'required|min:2',
            'requirements' => 'required|min:2',
            'date' => 'required|min:3'
        ]);
   
        $job = Job::where('id', '=', $data['id'])->first();

        if($job) {
            $old = clone $job;

            $job -> salary = $data['salary'];
            $job -> description = $data['description'];
            $job -> address = $data['address'];
            $job -> requirements = $data['requirements'];
            $job -> date = $data['date'];

            if($job->save()){
                return response() ->json([
                    'message' => 'Trabajo actualizado correctamente',
                    'old' => $old,
                    'new' => $job
                ]);
            }else{
                return response() ->json([
                    'message' => 'Error al actualizar un trabajo',
                ]);
            }
        }else{
            return response() ->json([
                'message' => 'Elemento no encontrado',
            ]);
        }
    }
}
