<?php

namespace App\Http\Controllers;

use App\models\PaperType;
use App\models\ActivityLog;
use App\models\MailContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth ;

class PaperTypeController extends Controller
{

            // create new PaperType By admin
            public function create(Request $request)
            
            {  
                $user_id = Auth::user()->id;
                $papertype = new PaperType($request->type);
                if ($papertype['is_renewing'] ){
                    $email = new MailContent($request->email) ;
                    $email->save();
                    $papertype->email_id = $email->id ;

                }
                $papertype->save();
               


                $activity = new ActivityLog();
                $activity->logSaver($user_id,'create','paperType',$papertype->paper_type);
                return response()->json(['message'=>'created']) ;
            }




            // update PaperType by user&admin
            public function update(Request $request)
            {

                $user_id = Auth::user()->id;

                $typeId = $request->newType['id'] ;
                $paperType = PaperType::find($typeId) ;
               if(($paperType->email_id) && ( $request->newType['is_renewing'])){
                 // update existed mail
                $email = MailContent::find($paperType->email_id) ;
                $email->update($request->newEmail) ;
                $email->save() ;
                $paperType->update($request->newType);
                $paperType->save();
               }else if (!($paperType->email_id) && ( $request->newType['is_renewing']) ){
                // create new mail
                   $email = new MailContent($request->newEmail) ;
                   $email->save() ;
                   $paperType->update($request->newType);
                   $paperType->email_id = $email->id  ;
                   $paperType->save();


               }else if(($paperType->email_id) && !( $request->newType['is_renewing'])){
                $paperType->update($request->newType);
                $paperType->save();
               }else if (!($paperType->email_id) && !( $request->newType['is_renewing']))
               {
                $paperType->update($request->newType);
                $paperType->save();
               }



                 $activity = new ActivityLog();
                $activity->logSaver($user_id,'update','paperType',$paperType->paper_type);
                return response()->json('updated') ;
            }



            //get all PaperType for admin
            public function getAllpaperTypes()
            {
                $paperTypes = PaperType::with('email')->get() ;
                return $paperTypes ;
            }


            // get PaperType By id
            public function getpaperTypeById($id)
            {
                $paperType = PaperType::find($id);
                if(is_null($paperType))
                {
                    return response()->json(["message"=>"Not found"]);
                }
                return $paperType ;
            }


            // delete PaperType by admin
            public function delete(Request $request)
            {

                $user_id = Auth::user()->id;
                $table = $request->types;
                foreach ($table as $t)
                {
                    $id= ($t['type_id']);
                    $type = PaperType::find($id);
                    $email_id =$type->email_id ;
                    $type->delete();
                    if($email_id != NULL){
                    $email = MailContent::find($email_id);
                    $email->delete() ;
                    }

                    $activity = new ActivityLog();
                    $activity->logSaver($user_id,'delete','paperType',$type->paper_type);
                }
                return response()->json(['message'=>'Deleted']) ;

            }
//get papers type
            public function getPaperofTheType($id)
    {
        $paperType = PaperType::where('id',$id)->with('paper')->get();
        return response($paperType);
    }






}
