<?php

namespace App\Http\Controllers;

use App\models\Bill;
use App\models\Item;
use App\models\User;
use App\models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth ;
use App\models\ActivityLog;
use Carbon\Carbon;


class BillController extends Controller
{
    // create new bill By admin
    public function create(Request $request)
    {
        $user_id = Auth::user()->id ; 
        $bill = new Bill($request->bill);
        $bill->billNum = $request->config['billNum'] ;
        $bill->client_id = $request->config['clientId'] ;
        $bill->fiscal_timber = $request->config['tax'] ;
        $bill->rate_tva = $request->config['tva'] ;
        $bill->save();
        $bill_id = $bill->id  ;
        $items = $request->items;
      foreach($items as $item)
      {
            $i = new Item($item);
            $i->bill_id = $bill_id ;
            $i->save();
           
      }

      $activity = new ActivityLog();
      $activity->logSaver($user_id,'create','bill',$bill->billNum);
         return response()->json(['message'=>'created']) ;
    }

    // update bill by user&admin
    public function update(Request $request, $id)
    {
        
        $user_id = Auth::user()->id ; 
         $newBill = $request->bill ;
         $items = $request->itsmes ;
         $config = $request->config ;
        $bill = Bill::find($id) ;
        $bill->update([
            "total_ttc" => $newBill['total_ttc'] ,
            "ht_price" => $newBill['ht_price'],
            "rate_tva" => $config['tva'],
            "price_tva" => $newBill['price_tva'],
            "fiscal_timber" => $config['tax'],
            "billNum" => $config['billNum'],
            "DateFacturation" => $config['dateFacturation'],
            "description" => $newBill['description'],
            "client_id" => $config['clientId'],
            "inWord" => $newBill['inWord']
        ]);
        $bill->save();


        //delete old items
        $bill_id = $bill->id;
        $items =  Item::where('bill_id',$bill_id)->get();
        foreach($items as $item)
        {
              $bill_id = $bill->id;
              $items = Item::where('bill_id',$bill_id)->delete();
        }

        //save new item
        $items = $request->items;
        foreach($items as $item)
        {
              $i = new Item($item);
              $i->bill_id = $bill_id ;
              $i->save();
        }
            $activity = new ActivityLog();
            $activity->logSaver($user_id,'update','bill',$bill->billNum);
        return response()->json(['message'=>'updated']) ;
    }

     //get all bills for admin
     public function getAllBills()
     {
         
         $bills = Bill::with('client')->get() ;
         return response()->json(["bills"=> $bills ]);
     }


     // get bill By id
     public function getBillById($id)
        {
            $bill = Bill::find($id);
            $items= Item::where('bill_id',$id)->get();
            return response()->json(["bill"=> $bill, "items"=>$items]);
        }


     // delete Bill by admin
     public function delete(Request $request)

     {
         $table = $request->bills_id;
         foreach ($table as $t)
         {
             $id= ($t['bill_id']);
             $bill = Bill::find($id);
             $bill->delete();
         }
         return response()->json(['message'=>'Deleted']) ;
     }

    // get items of the bills
    public function test1($id)
    {
        $bill = Bill::where('id',$id)->with('item')->get();
        return response($bill);

    }

    //Calculate bills number
    public function calcNumBills(Request $request){
        $bills = Bill::whereYear('DateFacturation',$request->year)->get() ; 
        return response()->json(["numBill"=>count($bills)]);
    }








    public function getLastBill()
    {
        $bill = Bill::latest()->first();
        if($bill){

            return $bill ;
        }else {
            return 0 ;
        }
    }



  public function getDateLimits(Request $request)
  {
      $bills = Bill::all() ;
      $numBill =  count($bills);
      if($numBill == 1 )
      {
        return response()->json(["limit"=>3]);
      } 
      $ids = array() ;
      foreach($bills as $bill)
      {
          array_push($ids ,$bill['id']) ;
      }
      $key = array_search($request->id, $ids); 
    if($key == 0){
        $key ++ ; 
        // return $key ; 
     $bill = Bill::find($ids[$key]);
     return response()->json(["bill"=>$bill,"limit"=>0]);

   } else if($key == count($ids)-1){
      $key -- ;
      $bill = Bill::find($ids[$key]);
      return response()->json(["bill"=>$bill,"limit"=>1]);

    }else{
     $prev_Bill = Bill::find($ids[$key - 1]) ;
     $next_bill = Bill::find($ids[$key + 1]); 
     return response()->json(["prev_bill"=>$prev_Bill,"next_bill"=>$next_bill,'limit'=>2]);
    }

  }



  public function changeStatus(Request $request)
  {
      $bill_id = $request->bill_id ;
      $bill = Bill::find($bill_id);
      $bill->status = $request->newStatus ;
      $bill->save();
      return response()->json(['msg'=>'updated']);
  }
}
