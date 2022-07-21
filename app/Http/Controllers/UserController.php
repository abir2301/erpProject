<?php

namespace App\Http\Controllers;
use Carbon\Carbon;

use App\models\User;
use App\models\Role;
use App\models\Action;
use App\models\Space;
use App\models\Client;
use App\models\Project;
use App\models\Contact;
use App\models\Privilege;
use App\models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth ;
use Illuminate\Support\Facades\Validator ;
use Illuminate\Support\Facades\Crypt ;
use Illuminate\Support\Facades\Mail;
class UserController extends Controller
{
    //


            // create new user By admin
            public function create(Request $request)
            {
                 

                $user_id = Auth::user()->id;
                //$userr = $request->input('email');
                $email = $request->input('email');
                $isFound = User::where('email',$email)->first();
               if($isFound)
               {
                    return response()->json(["message" => "Email already Used"],409) ;
               }


                    $password = "nachd-it";
                    $user=User::create([
                        'name'=> $request->input('name'),
                        'email'=> $request->input('email'),
                        'password'=> Hash::make($password) ,
                        'role_id' => $request->input('role_id'),
                        'photo' => 'files/files/std.png'
                    ]);

                    $user->save();


                   // sending verification email

                    $today = Carbon::today();
                    $token = array("date"=>$today, "user_id"=>$user->id , "isUsed"=> 0);
                    $cryptedToken = Crypt::encryptString(json_encode($token)) ;
                  
                    $to_name  = $user->name;
                    $to_email = $user->email;
                    $data = array('name'=> $user->name ,'link' => "http://localhost:4200/updatePassword/".$cryptedToken);
                    // Mail::send('verificationEmail', $data, function($message) use ($to_name, $to_email) {
                    // $message->to($to_email, $to_name)->subject('Verification');
                    // $message->from(env('MAIL_USERNAME'),'Nachd-it');
                    // });
                    $user->update([
                        'token'=>$cryptedToken 
                    ]);
                    $user->save();
                    return response()->json(['message'=>'created','user'=>$user]) ;


            }




            // update user by user
            public function update(Request $request)
            {

                $user_id = Auth::user()->id;
               // return  response()->json(["message" => "$user_id"]) ;

                $user = User::find($user_id) ;
               //  return  response()->json(["message" => "$user"]) ;

    //             $userr=  User::create([
    //             'name' => $request->input('name'),
    //             'email' => $request->input('email'),
    //             'phone_number'=> $request->input('phone_number'),
    //             'photo'=> $request->input('photo'),
       
       

    //   ]);
                $userr = $request->user;
                if ($userr == NULL)
                {
                    return  response()->json(["message" => "error to find  user "]) ;
                }
                $email = $userr['email'];
                $emailChanged = false ; 


                if (($userr['email'] != $user->email))
                    {
                        $isFound = User::where('email',$email)->where('id','<>',$user_id)->first();
                        if($isFound )
                        {
                          return response()->json(["message" => "Email already Used"],409) ;
                        }
                        $user->update([
                        'name'=> $userr['name'],
                        'email'=>$userr['email'] ,
                        'phone_number' => $userr['phone_number'],
                        'photo' => $request->path ? $request->path : $user->photo ,

                ]);
                $user->save() ;

                return response()->json(["emailChanged"=>"update user acount ","new acount " => $user] ) ;

                      //$emailChanged = $this->verifMail($user->email,$userr['email'],$user->user_name,$user_id) ; 
                     
                    }


            



                
            }

                // update user by admin
                public function updateUserByAdmin(Request $request)
                {
                    $user_id = $request->user_id ;
                    $user = User::find($user_id) ;
                    if ($user ==NULL)
                    return response()->json(["message" => "user does not exist "]) ;
                   $newEmail  = $request->newUser['email'] ; 
                   if($newEmail != $user->email)
                    {
                        $isFound = User::where('email',$newEmail)->where('id','<>',$user_id)->first() ; 
                        if($isFound)
                        {
                          return response()->json(["message" => "Email already Used"],409) ;
                        }
                    //    $var =   $this->verifMail($newEmail,$newEmail,$user->name,$user_id)  ; 

                    }
                 
             
                //    {
                //        // seding main verif 
                //    }
                     $user->update($request->newUser) ;
                     $user->save();
                     return response()->json(["msg"=>"updated!"]); 
                }



            //get all users for admin
            public function getAllUsers()
            {
                // $users = User::all()->with('role')->get() ;
                $users = User::with('role')->where('name','<>','admin')->get() ;
                return $users ;
            }


            // get user By id
            public function getUserById($id)
            {
                $user = User::find($id);
                if(is_null($user))
                {
                    return response()->json(["message"=>"Not found"]);
                }
                $role_id=$user->role_id ;
                return $user ;
            }


            // delete user by admin
            public function delete( $id)
            {

                $user_id = Auth::user()->id;
               // $table = $request->users_id;

               
                   
                    $user = User::find($id);
                    if ($user != NULL)
                     {
                      $user->delete();
                
                       return response()->json(['message'=>'Deleted']) ;}
                else 
                return response()->json(['message'=>' not found user ']) ;


            }



            //login
            public function login(Request $request)
            {
                $login = $request->validate([
                    'email' => 'required|string',
                    'password' => 'required|string'
                ]) ;



                        if(!Auth::attempt($login))
                        {
                            return response(['message'=>'invalid login credentials'],403);
                        }

                        $user_id = Auth::user()->id;
                        $user =  User::where('id',$user_id)->with('role')->first() ; 
                        $role_id = $user->role_id;
                        $privileges = Privilege::WHERE('role_id',$role_id)->with('space')->with('action')->get() ;
                        $accessToken = Auth::user()->createToken('authToken')->accessToken ;
                        $isVerified = $user->verified
                         ;
                        if(!$isVerified)
                        {
                            return response(['message'=>'invalid login credentials'],403);

                        }
                        return response()->json(['user'=>$user, 'token' => $accessToken ,'privileges'=>$privileges]) ;

            }






            public function search(Request $request)
            {
                    $searchKey = $request->searchKey ;

                    $clients = Client::where('client_name','like',"%".$searchKey."%")->get();
                    $projects = Project::where('project_name','like','%'.$searchKey.'%')->with('client')->get();
                    $contacts = Contact::where('contact_name','like','%'.$searchKey.'%')->get();
                    return response()->json(["clients"=>$clients,"projects"=>$projects,"contacts"=>$contacts]);
            }



        public function changePassword(Request $request)
        {

            $token  = $request->token ;
        $decryptedToken = Crypt::decryptString($token) ;
        $jsonToken =  json_decode($decryptedToken, true) ;
        $user_id = $jsonToken['user_id'] ;
        $jsonToken['isUsed'] = 1 ;
        $cryptedToken = Crypt::encryptString(json_encode($jsonToken)) ;

            $user = User::find($user_id) ;
            $user->update([
                'password'=>Hash::make($request->password),
                'token' => $cryptedToken
            ]);

            $user->save() ;
            $user->verified = 1  ;
            $user->save();
            return response()->json(["msg"=>"updated"]) ;


        }




        public function sendMail(Request $request)
        {

            $email = $request->email ;
            $user =  User::where('email',$email)->first() ;
            if(is_null($user)){
                return  response()->json(["msg"=>"User not found"],403);
            }

            $today = Carbon::today();
            $token = array("date"=>$today, "user_id"=>$user->id , "isUsed"=> 0);
            $cryptedToken = Crypt::encryptString(json_encode($token)) ;
            $user->update([
                'token' => $cryptedToken
            ]) ;
            $user->save() ;
            $to_name  = $user->name;
            $to_email = $user->email;
            $data = array('name'=> $user->name ,'link' => "http://localhost:4200/resetPassword/".$cryptedToken);
            Mail::send('emails', $data, function($message) use ($to_name, $to_email) {
            $message->to($to_email, $to_name)->subject('Reset Password');
            $message->from(env('MAIL_USERNAME'),'Nachd-it');
            });
            return response()->json(["msg"=>"Mail sent"]);
        }



        public function resetPassword(Request $request)
        {

        $token  = $request->token ;
        $decryptedToken = Crypt::decryptString($token) ;
        $jsonToken =  json_decode($decryptedToken, true) ;
        $user_id = $jsonToken['user_id'] ;
        $jsonToken['isUsed'] = 1 ;
        $cryptedToken = Crypt::encryptString(json_encode($jsonToken)) ;


        $user = User::find($user_id) ;
        $user->update([
             "password"  => Hash::make($request->newPassword),
             "token" => $cryptedToken,
             ]);
        $user->save();
        return response()->json(["msg"=>"password changed"]);
        }





        public function checkToken(Request $request)
        {
            $token =  $request->token;
            $decryptedToken =  Crypt::decryptString($token) ;
            $decryptedToken =  json_decode($decryptedToken, true) ; 
            $user = User::find($decryptedToken['user_id']) ;
            if(!$user){
                return response()->json(["isChecked"=> 1]);

            }
            $userToken = $user->token ;
            $userToken =  Crypt::decryptString($userToken) ;
            $userToken =  json_decode($userToken, true) ;
            // return $userToken ; 

            if(!($decryptedToken == $userToken))
            {
                return response()->json(["isChecked"=> 1]);
            }else{
                return response()->json(["isChecked"=> 0]);



            }


        }




        public function updatePassword(Request $request)

        {
            $user_id =  Auth::user()->id;
            $user =  User::find($user_id);
            $password = $user->password ;
            $currentPassword =  $request->currentPassword ;
            $isEqual =  Hash::check($currentPassword, $password) ;
            if($isEqual)
    
             {
               $user->password = Hash::make($request->newPassword) ;
               $user->save();
               return response()->json(["msg"=>"password updated","status"=>"1"]);
             }else {
                return response()->json(["msg"=>"Wrong Password","status"=>"0"]);
    
             }
    
        }


        public function getConnectedUser()
        {
            $id = Auth::user()->id ;
            $user =  User::where('id',$id)->with('role')->first() ; 
             
            return $user ;
        } 
   





        public function verifMail($receiver,$newEmail,$name,$user_id)
        {
            $today = Carbon::today();
            $token = array("date"=>$today,"oldEmail"=>$receiver , "newEmail"=> $newEmail,"isUsed"=>0,"user_id"=>$user_id);
            $cryptedToken = Crypt::encryptString(json_encode($token)) ;
            $user = User::find($user_id);
            $user->update([
                "token" => $cryptedToken,
                "verified" => 0
            ]) ; 
            $user->save();
            $to_name  = $name;
            $to_email = $receiver;
            $data = array('name'=> $name ,'link' => "http://localhost:4200/verifNewEmail/".$cryptedToken);
            Mail::send('verifEmail', $data, function($message) use ($to_name, $to_email) {
            $message->to($to_email, $to_name)->subject('Email Validation');
            $message->from(env('MAIL_USERNAME'),'Nachd-it');
            });

            return true  ;
        }


     public function updateEmail(Request $request)
     {

         $token = $request->token ; 
         $currentPassword = $request->password ; 
        
         
         $decryptedToken =  Crypt::decryptString($token) ;
         $decryptedToken =  json_decode($decryptedToken, true) ;
        

         
         $user = User::where('email',$decryptedToken['oldEmail'])->first();
         $isEqual =  Hash::check($currentPassword, $user->password) ;
         if($isEqual)
         {
            $decryptedToken['isUsed'] = 1 ;
            $cryptedToken = Crypt::encryptString(json_encode($decryptedToken)) ;

             $user->update([
                 "email"=> $decryptedToken['newEmail'],
                 "token"=> $cryptedToken,
                 "verified"=> 1
             ]) ; 
             $user->save() ; 
             return response()->json(["isChanged"=>1]);
         }
         return response()->json(["isChanged"=>0]);
       

         

     }
     }

