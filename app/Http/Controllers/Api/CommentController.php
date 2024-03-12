<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;


class CommentController extends Controller
{
    //
    public function list(){
        $categories = Comment::all();
        $list = [];

        foreach($categories as $category){
            $object = [
                "id" => $category->id,
                "user" => $category->user,
                "offer_id" => $category->offer_id,
                "comment" => $category->comment,

                "created_at" => $category->created_at,
                "updated_at" => $category->updated_at,
            ];
            
            array_push($list, $object);
        }

        return response()->json($list);
    }

    public function commentsOffer($offerId){
        $comments = Comment::where('offer_id', '=', $offerId)->get();
        $commentData = [];
        
        foreach ($comments as $comment) {
            $commentData[] = [
                "id" => $comment->id,
                "user"=> $comment->user,
                "offer_id"=> $comment->offer_id,
                "comment" => $comment->comment,
            ];
        }

        if(!$commentData){
            return response()->json([
                'message' => "Error al obtener los elementos"
            ]);
        }
        return response()->json($commentData);

    }


    public function item($id){
            $category = Comment::where('id', '=', $id)->first();
                $object = [
                    "id" => $category->id,
                    "user" => $category->user,
                    "offer_id" => $category->offer_id,
                    "comment" => $category->comment,
                    "created_at" => $category->created_at,
                    "updated_at" => $category->updated_at,
                ];
            return response()->json($object);
    }
}
