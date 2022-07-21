<?php

namespace App\Http\Controllers;

use App\models\Client;
use App\models\User;
use App\models\Action;
use App\models\Space;
use App\models\Contact;
use App\models\Project;
use App\models\ActivityType;
use App\models\ActivityLog;
use Illuminate\Support\Facades\Auth ;
use Illuminate\Http\Request;
class ClientController extends Controller
{



    // create Client
    public function create(Request $request)
    {
           //    'client_name','sub_name' , 'abbreviation','email','webSite','address','matFisc','fax','phone','other'
           

       $user_id = Auth::user()->id;
        $client = client::create([
        'client_name' => $request->input('client_name'),
        'sub_name' => $request->input('sub_name'),
        'abbreviation'=> $request->input('abbreviation'),
        'email'=> $request->input('email'),
        'address'=> $request->input('address'),
        'matFisc'=> $request->input('matFisc'),
        'fax'=> $request->input('fax'),
        'phone'=> $request->input('phone'),
       
          //'password' => bcrypt($request->input('password')),

      ]);
      
       if ( $client->save()){
         return response()->json(['message'=>'created','client'=>$client]) ;
       }
else {
     return response()->json(['message'=>' not created']) ;
}
                    //  $activity = new ActivityLog();
                    // $activity->logSaver($user_id,'create','client',$client->client_name);

                   

    }




    // update client
    public function update(Request $request, $id)
    {

        $user_id = Auth::user()->id;
        $client = Client::find($id) ;
        if(is_null($client))
        {
            return response()->json(["message"=>"Not found"]);
        }

        $client->update([
        'client_name' => $request->input('client_name'),
        'sub_name' => $request->input('sub_name'),
        'abbreviation'=> $request->input('abbreviation'),
        'email'=> $request->input('email'),
        'address'=> $request->input('address'),
        'matFisc'=> $request->input('matFisc'),
        'fax'=> $request->input('fax'),
        'phone'=> $request->input('phone'),
       
          //'password' => bcrypt($request->input('password')),

      ]);
        $client->save();

      
        $activity = new ActivityLog();
        $activity->logSaver($user_id,'update','client',$client->client_name);
        return response()->json(['message'=>'updated','client'=>$client]) ;

    }


        // delete client by admin
        public function delete(Request $request)
        {
          $user_id = Auth::user()->id;
          $table = $request->clients_id;


          foreach ($table as $t)
          {
              $id= ($t['client_id']);
              $client = Client::find($id);
              $projects = Project::Where('client_id',$id)->first();
              $client->delete() ;



              $activity = new ActivityLog();
              $activity->logSaver($user_id,'delete','client',$client->client_name);
          }

          
         
            return response()->json(['message'=>'Deleted']) ;


        }

   // get all Clients
   public function getAllclients()
   {
       $clients = Client::all() ;
       return $clients ;
   }

    // get user clients
   public function getUserClients($id)
   {

       $clients = Client::where('creator_id',$id)->get();


       if(is_null($clients))
       {
           return response()->json(["message"=> "not found"]);
       }

       return $clients ;
   }

   // get client by id
    public function getClientById($id)
    {
        $client = Client::where('id',$id)->withTrashed()->first();
        return response()->json(["data"=> $client]);
    }



        // get project of the client
        public function projectClient($id){
            $client = Client::Where('id',$id)->with('project')->get();
            return $client;
        }



        //get contacts of the client
        public function getClientContact($id)
        {
            $client = Client::where('id',$id)->with('contact')->get();
            return $client;
        }

        
        // get bills of the client
    public function test($id)
    {
        $client = Client::where('id',$id)->with('bill')->get();
        return response($client);

    }

    public function test1($id)
    {
        $client = Client::where('id',$id)->with('contact')->get();
        return response($client);

    }

// get clients with projects
   public function ClientsWithProjects()
    {
       $clients = Client::with('project')->get();
       return $clients;
    }

    // get clients with contacts
    public function clientWithContacts()
    {
        $clients = Client::with('contact')->get();
       return $clients;
    }



}
