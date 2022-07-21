<?php

namespace App\Http\Controllers;

use App\models\QuoteItems;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class QuoteItemsController extends Controller
{ // create new item By admin
    public function create(Request $request)
    {
        $item = new QuoteItems($request->item);
        $item->save();

         return response()->json(['message'=>'created','item'=>$item]) ;
    }



    // update item by user&admin
    public function update(Request $request, $id)
    {
        $item = QuoteItems::find($id) ;
        if(is_null($item))
        {
            return response()->json(["message"=>"Not found"]);
        }
        $item->update($request->all());
        return response()->json('updated') ;
    }



    //get all Contact for admin
    public function getAllItems()
    {
        $items = QuoteItems::all() ;
        return $items ;
    }


    // get Contact By id
    public function getItemById($id)
    {
        $item = QuoteItems::find($id);
        if(is_null($item))
        {
            return response()->json(["message"=>"Not found"]);
        }
        return $item ;
    }


    // delete Contact by admin
    public function delete($id)
    {
        $item =QuoteItems::find($id) ;
        if(is_null($item))
        {
            return response()->json(["message"=>"Not found"]);
        }
        $item->delete() ;
        return response()->json(['message'=>'Deleted']) ;

    }
}
