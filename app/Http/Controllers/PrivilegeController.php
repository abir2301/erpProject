<?php

namespace App\Http\Controllers;

use App\models\Privilege;
use Illuminate\Http\Request;

class PrivilegeController extends Controller
{
   // create privilege

   public function create(Request $request)
   {
       $privilege = new Privilege($request->all());
       $privilege->save() ; 
       return response()->json(['message'=>'created','role'=>$privilege]) ;
   }


   // update privilege by admin
   public function update(Request $request, $id)
   {
       $privilege = Privilege::find($id);
       if(is_null($privilege)) {
           return response()->json(["message"=>"Not found"]);
        }
        $privilege->update($request->all());
        return response()->json('updated') ;
    }


    // get all privilege by admin
    public function getAllPrivileges()
    {
        $privilege = Privilege::all();
        return $privilege;
    }

    

    // get privilege by id
    public function getPrivilegeById($id)
    {
        $privilege = Privilege::find($id);
        if(is_null($privilege)) {
            return response()->json(["message"=>"Not found"]);
         }
         return $privilege ;
    }


    // delete privilege by admin
    public function delete($id)
    {
       $privilege = Privilege::find($id);
       if(is_null($privilege)) {
        return response()->json(["message"=>"Not found"]);
     }
     $privilege->delete();
     return response()->json(['message'=>'Deleted']) ;

    }   
}