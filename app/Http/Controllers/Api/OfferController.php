<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Offer;
use App\Models\companie;
use App\Models\User;

class OfferController extends Controller
{
    public function list(){
        $offers = Offer::all();
        $list = [];

        foreach($offers as $offer){
            $object = [
                "id" => $offer->id,
                "title" => $offer->title,
                "description" => $offer->description,
                "image" => $offer->image,
                "user"=> $offer->user,
                "job"=> $offer->job,
                "companie" => $offer->companie,
                "categorie" => $offer->categorie,
                "created_at" => $offer->created_at,
                "updated_at" => $offer->updated_at,
            ];
            
            array_push($list, $object);
        }

        return response()->json($list);
    }


    public function offersUser($userId){
        $offers = Offer::where('user_id', '=', $userId)->get();
        $offerData = [];
        
        foreach ($offers as $offer) {
            $offerData[] = [
                "id" => $offer->id,
                "title"=> $offer->title,
                "description"=> $offer->description,
                "image" => $offer->image,
                "job" => $offer->job,
                "user" => $offer->user,
                "categorie" => $offer->categorie,

                "companie" => $offer->companie,
            ];
        }

        if(!$offerData){
            return response()->json([
                'message' => "Error al obtener los elementos"
            ]);
        }
        return response()->json($offerData
        );

    }

    public function offersTitle($title){
        $offers = Offer::where('title', 'LIKE', "%{$title}%")->get();
        $offerData = [];
        
        foreach ($offers as $offer) {
            $offerData[] = [
                "id" => $offer->id,
                "title"=> $offer->title,
                "description"=> $offer->description,
                "image" => $offer->image,
                "job" => $offer->job,
                "user" => $offer->user,
                "categorie" => $offer->categorie,

                "companie" => $offer->companie,
            ];
        }

        if(!$offerData){
            return response()->json([
                'message' => "Error al obtener los elementos"
            ]);
        }
        return response()->json($offers);
    }

    public function saveOffer($offerId){

    }

    public function item($id){
        $offer = Offer::where('id', '=', $id)->first();
                $object = [
                    "id" => $offer->id,
                    "title" => $offer->title,
                    "description" => $offer->description,
                    "image" => $offer->image,
                    "user"=> $offer->user,
                    "job"=> $offer->job,
                    "companie" => $offer->companie,
                    "categorie" => $offer->categorie,
                        "created_at" => $offer->created_at,
                        "updated_at" => $offer->updated_at,
                    ];

        
            return response()->json($object);
    }

    public function update(Request $request){
        $data = $request -> validate([
            'id' => 'required|numeric',
            'title'=> 'required|string',
            'description'=> 'required|string',
            'image' => 'required|string',
            'user_id' => 'required|numeric',
            'job_id' => 'required|numeric',
            'companie_id' => 'required|numeric',
            'categorie_id' => 'required|numeric',
        ]);
   
        $offer = Offer::where('id', '=', $data['id'])->first();

        if($offer) {
            $old = clone $offer;

            $offer -> title = $data['title'];
            $offer -> description = $data['description'];
            $offer -> image = $data['image'];
            $offer -> user_id = $data['user_id'];
            $offer -> job_id = $data['job_id'];
            $offer -> companie_id = $data['companie_id'];
            $offer -> categorie_id = $data['categorie_id'];

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
            'title'=> 'required|string',
            'description'=> 'required|string',
            'image' => 'required|string',
            'user_id' => 'required|numeric',
            'job_id' => 'required|numeric',
            'companie_id' => 'required|numeric',
            'categorie_id'=> 'required|numeric',
        ]);


        

        $job = Offer::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'image' => $data['image'],
            'user_id' => $data['user_id'],
            'job_id' => $data['job_id'],
            'companie_id' => $data['companie_id'],
            'categorie_id' => $data['categorie_id']
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
