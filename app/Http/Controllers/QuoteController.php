<?php

namespace App\Http\Controllers;

use App\models\Quote;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\models\QuoteItems;
use App\models\User;
use App\models\Client;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth ;
use App\models\ActivityLog;
use Carbon\Carbon;

class QuoteController extends Controller
{
     // create new Quote By admin
     public function create(Request $request)
     {
         
         $user_id = Auth::user()->id ;
         $quote = new Quote($request->quote);
         $quote->quoteNum = $request->config['quoteNum'] ;
         $quote->client_id = $request->config['clientId'] ;
         $quote->fiscal_timber = $request->config['tax'] ;
         $quote->rate_tva = $request->config['tva'] ;
         $quote->save();
         $quote_id = $quote->id  ;
         $items = $request->items;
       foreach($items as $item)
       {
             $i = new QuoteItems($item);
             $i->quote_id = $quote_id ;
             $i->save();
       }

       $activity = new ActivityLog();
       $activity->logSaver($user_id,'create','quote',$quote->QuoteNum);
          return response()->json(['message'=>'created']) ;
     }

     // update quote by user&admin
    public function update(Request $request, $id)
    {

         $user_id = Auth::user()->id ;
         $newQuote = $request->quote ;
         $items = $request->itsmes ;
         $config = $request->config ;
         $quote = Quote::find($id) ;
         $quote->update([
            "total_ttc" => $quote['total_ttc'] ,
            "ht_price" => $quote['ht_price'],
            "rate_tva" => $config['tva'],
            "price_tva" => $quote['price_tva'],
            "fiscal_timber" => $config['tax'],
            "quoteNum" => $config['quoteNum'],
            "DateFacturation" => $config['dateFacturation'],
            "description" => $quote['description'],
            "client_id" => $config['clientId'],
            "inWord" => $quote['inWord']
        ]);
        $quote->save();
     

        //delete old items
        $quote_id = $quote->id;
        $items =  QuoteItems::where('quote_id',$quote_id)->get();
        foreach($items as $item)
        {
              $quote_id = $quote->id;
              $items = QuoteItems::where('quote_id',$quote_id)->delete();
        }

        //save new item
        $items = $request->items;
        foreach($items as $item)
        {
              $i = new QuoteItems($item);
              $i->quote_id = $quote_id ;
              $i->save();
        }
        $activity = new ActivityLog();
        $activity->logSaver($user_id,'update','quote',$quote->QuoteNum);
        return response()->json(['message'=>'updated']) ;
    }

     //get all quote for admin
     public function getAllquotes()
     {
         $quotes = Quote::with('client')->get() ;

         return response()->json(["quotes"=> $quotes ]);
     }

     // get quote By id
     public function getquoteById($id)
        {
            $quote = Quote::find($id);
            $items= QuoteItems::where('quote_id',$id)->get();
            return response()->json(["quote"=> $quote, "items"=>$items]);
        }

      // delete quote by admin
      public function delete(Request $request)
      {
          $tables = $request->quotes_id;
          foreach ($tables as $tab)
          {
              $id= ($tab['quote_id']);
              $quote = Quote::find($id);
              $quote->delete();
          }
          return response()->json(['message'=>'Deleted']) ;
      }

     //Calculate quotes number
     public function calcNumquotes(Request $request){
        $quotes = Quote::all() ;
        $thisYearquote = array();
        $year = $request->year;
        foreach ($quotes as $quote) {
        $date = Carbon::createFromFormat('Y-m-d H:i:s', $quote->DateFacturation);
        $quoteYear = $date->format('Y');
        if ($quoteYear == $year) {
            array_push($thisYearquote,$quote);
        }
        }
        return response()->json(["numquote"=>count($thisYearquote)]);
    }

    public function getLastquote()
    {
        $quote = Quote::latest()->first();
        if($quote){

            return $quote ;
        }else {
            return 0 ;
        }
    }



  public function getDateLimits(Request $request)
  {
      $quotes = Quote::all() ;
      $ids = array() ;
      foreach($quotes as $quote)
      {
          array_push($ids ,$quote['id']) ;
      }
      $key = array_search($request->id, $ids); 
    
    if($key == 0){
        $key ++ ; 
     $quote = Quote::find($ids[$key]);
     return response()->json(["quote"=>$quote,"limit"=>0]);

   } else if($key == count($ids)-1){
      $key -- ;
      $quote = Quote::find($ids[$key]);
      return response()->json(["quote"=>$quote,"limit"=>1]);

    }else{
     $prev_quote = Quote::find($ids[$key - 1]) ;
     $next_quote = Quote::find($ids[$key + 1]); 
     return response()->json(["prev_quote"=>$prev_quote,"next_quote"=>$next_quote,'limit'=>2]);
    }

  }
}
