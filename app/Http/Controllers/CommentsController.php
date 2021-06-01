<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Products;
use App\Comments;

class CommentsController extends Controller
{
    public function store(Request $request)
    {
    	$comment= new Comments;
        $comment->commentary = $request->commentary;
        $comment->product_id = $request->product_id;
        $comment->save();

        return $response=1;
    }

    public function delete(Request $request)
    {
    	$comment=Comments::find($request->id);
        $comment->delete();

        return $response=1;
    }
}
