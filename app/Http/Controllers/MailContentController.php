<?php

namespace App\Http\Controllers;

use App\models\MailContent;
use Illuminate\Http\Request;

class MailContentController extends Controller
{
   // create new MailContent By admin
   public function create(Request $request)
   {
       $mailContent=MailContent::create([

       ]);
       return response()->json(['message'=>'created']) ;
   }




   // update MailContent by user&admin
   public function update(Request $request, $id)
   {
       $mailContent = MailContent::find($id) ;
       if(is_null($mailContent))
       {
           return response()->json(["message"=>"Not found"]);
       }
       $mailContent->update($request->all());
       return response()->json('updated') ;
   }



   //get all MailContents for admin
   public function getAllMailContents()
   {
       $mailContents = MailContent::all() ;
       return $mailContents ;
   }


   // get MailContent By id
   public function getMailContentById($id)
   {
       $mailContent = MailContent::find($id);
       if(is_null($mailContent))
       {
           return response()->json(["message"=>"Not found"]);
       }
       return $mailContent ;
   }


   // delete MailContent by admin
   public function delete($id)
   {
       $mailContent = MailContent::find($id) ;
       if(is_null($mailContent))
       {
           return response()->json(["message"=>"Not found"]);
       }
       $mailContent->delete() ;
       return response()->json(['message'=>'Deleted']) ;

   }
}
