<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Offer;
use App\Models\OfferSave;
use Illuminate\Http\Request;


class OfferSaveController extends Controller
{
    //
    public function list(){
        $offerSaves = OfferSave::all();
        $list = [];

        foreach($offerSaves as $save){
            $object = [
                "id" => $save->id,
                "user" => $save->user,
                "offer" => $save->offer,
                "created_at" => $save->created_at,
                "updated_at" => $save->updated_at,
            ];
            
            array_push($list, $object);
        }
        return response()->json($list);
    }

    public function savedAllOfferUser($userId){
        $offerSaves = OfferSave::where('user_id', '=', $userId)->get();
        $offerData = [];

        foreach ($offerSaves as $offer) {
            $offerId = $offer->offer_id;
            $offers = Offer::where('id', '=', $offerId)->get();

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
                    "created_at" => $offer->created_at,
                ];
            }
        }

        if(!$offerData){
            return response()->json([
                'message' => "Error al obtener los elementos"
            ]);
        }
        return response()->json($offerData);
 
    }

    public function isOfferSaved(Request $request){
        $offerSave = OfferSave::where('user_id', '=', $request->user_id)->where('offer_id', '=', $request->offer_id)->first();
        if($offerSave){
            return response()->json([
                'saved' => 'true'
            ]);
        }
        return response()->json([
            "saved" => "false",
        ]);

    }

    public function savedRecentOfferUser($userId){
        $offerSaves = OfferSave::where('user_id', '=', $userId) -> orderBy('created_at', 'desc')->take(3)->get();
        $offerData = [];

        foreach ($offerSaves as $offerSave) {
            $offerId = $offerSave->offer_id;
            $offers = Offer::where('id', '=', $offerId)->get();

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
                    "created_at" => $offerSave->created_at,
                ];
            }
        }

        if(!$offerData){
            return response()->json([
                'message' => "Error al obtener los elementos"
            ]);
        }
        return response()->json($offerData);
    }


    public function item($id){
            $offer = OfferSave::where('id', '=', $id)->first();
                $object = [
                    "id" => $offer->id,
                    "user" => $offer->user,
                    "offer_id" => $offer->offer,
                    "created_at" => $offer->created_at,
                    "updated_at" => $offer->updated_at,
                ];
            return response()->json($object);
    }

    public function create(Request $request){
        $data = $request -> validate([
            'user_id'=> 'required|numeric',
            'offer_id'=> 'required|numeric',
        ]);


        $offer = OfferSave::create([
            'user_id' => $data['user_id'],
            'offer_id' => $data['offer_id'],
        ]);

        if($offer) {
            return response() ->json([
                'message' => 'Oferta creada correctamente',
                'data' => $offer
            ]);

        }else{
            return response() ->json([
                'message' => 'Error al crear un oferta',
            ]);
        }
    }

    public function delete(Request $request){
        $data = $request -> validate([
            'user_id'=> 'required|numeric',
            'offer_id'=> 'required|numeric',
        ]);

        $offer = OfferSave::where('user_id', '=', $data['user_id'])
        ->where('offer_id', '=', $data['offer_id'])
        ->first();

        if($offer) {
            $offer->delete();

            return response() ->json([
                'message' => 'Oferta eliminada correctamente'
            ]);

        }else{
            return response() ->json([
                'message' => 'Error al eliminar',
            ]);
        }
    }
}
