<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Offer;
use App\Models\Company;
use App\Models\User;

class OfferController extends Controller
{
    public function list(){
        $offers = Offer::all();
        $list = [];

        foreach($offers as $offer){
            $object = [
                "id" => $offer->id,
                "user"=> $offer->user,
                "job"=> $offer->job,
                "company_id" => $offer->company_id,
                "created_at" => $offer->created_at,
                "updated_at" => $offer->updated_at,
            ];
            
            array_push($list, $object);
        }

        return response()->json($list);
    }

    public function offersUser($userName){
        $users = User::where('name', 'LIKE', "%{$userName}%")->first();
        $offers = Offer::where('user_id', '=', $users -> id)->get();

        if ($users->isEmpty()) {
            return response()->json([
                'message' => "No se encontraron usuarios con el nombre proporcionado."
            ]);
        }
        
        $offerData = [];
        
        foreach ($offers as $offer) {
            $offerData[] = [
                "id" => $offer->id,
                "user_id" => $offer->user_id,
                "job_id" => $offer->job_id,
                "company_id" => $offer->company_id,
            ];
        }

        if(!$offerData){
            return response()->json([
                'message' => "Error al obtener los elementos"
            ]);
        }

        return response()->json([
            'offers' => $offers
        ]);
    }

    public function item($id){
        $offer = Offer::where('id', '=', $id)->first();
                $object = [
                    "id" => $offer->id,
                    "user_id"=> $offer->user_id,
                    "job_id"=> $offer->job_id,
                    "company_id" => $offer->company_id,
                        "created_at" => $offer->created_at,
                        "updated_at" => $offer->updated_at,
                    ];

        
            return response()->json($object);
    }

    public function update(Request $request){
        $data = $request -> validate([
            'id' => 'required|numeric',
            'user_id' => 'required|numeric',
            'job_id' => 'required|numeric',
            'company_id' => 'required|numeric',
        ]);
   
        $offer = Offer::where('id', '=', $data['id'])->first();

        if($offer) {
            $old = clone $offer;

            $offer -> user_id = $data['user_id'];
            $offer -> job_id = $data['job_id'];
            $offer -> company_id = $data['company_id'];

            if($offer->save()){
                return response() ->json([
                    'message' => 'Oferta creada correctamente',
                    'old' => $old,
                    'new' => $offer
                ]);
            }else{
                return response() ->json([
                    'message' => 'Error al crear una oferta',
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
            'user_id' => 'required|numeric',
            'job_id' => 'required|numeric',
            'company_id' => 'required|numeric',
        ]);

        $job = Offer::create([
            'user_id' => $data['user_id'],
            'job_id' => $data['job_id'],
            'company_id' => $data['company_id']
        ]);

        if($job) {
            return response() ->json([
                'message' => 'Oferta creada correctamente',
                'data' => $job
            ]);

        }else{
            return response() ->json([
                'message' => 'Error al crear un oferta',
            ]);
        }
    }
}
