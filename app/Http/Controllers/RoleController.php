<?php

namespace App\Http\Controllers;

use App\models\Role;
use App\models\Privilege;
use App\models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth ;

class RoleController extends Controller
{


    // create  role by admin
    public function create(Request $request)
    {  

                $id = Auth::user()->id;
                $role = new Role();
                $role->role_name = $request->input('role_name') ;
                $role->save() ;
                 

                return response()->json(['message'=>'created','table'=>$request->table]) ;
                $table=$request->table;
                foreach ($table as $priv)
                {
                    $privilege = new Privilege();
                    $privilege->action_id = $priv['action_id'];

                    $privilege->space_id  =  $priv['space_id'];
                    $privilege->role_id   =   $role->id;
                    $privilege->save();

                }
                
                $activity = new ActivityLog();
                $activity->logSaver($id,'create','role',$role->role_name);

         return response()->json(['message'=>'created','role'=>$role]) ;



        }





       // update role by admin
       public function update(Request $request, $id)

       {

                 $user_id = Auth::user()->id;

                    $role = Role::find($id) ;
                    if(is_null($role))
                    {
                        return response()->json(["message"=>"Not found"]);
                    }

                   $role->update($request->all()) ;

                   $role_id = $role->id;
                   $privilege = Privilege::where('role_id',$role_id)->delete();
                   

                   $table=$request->table;
                   foreach ($table as $priv)
                   {


                       $privilege = new Privilege();
                       $privilege->action_id = $priv['action_id'];
   
                       $privilege->space_id  =  $priv['space_id'];
                       $privilege->role_id   =   $role->id;
                       $privilege->save();
   
                   
                   }
    
                    
                    $activity = new ActivityLog();
                    $activity->logSaver($user_id,'update','role',$role->role_name);
                    return response()->json('updated') ;

       }




       // get all Roles by admin
       public function getAllRoles()
       {
           $roles = Role::where('role_name','<>','admin')->get( );
           return $roles ;
       }





       // get role by id
       public function getRoleById($id)
       {
             $role = Role::find($id) ;
             if(is_null($role))
             {
                 return response()->json(["message"=>"Not found"]);
             }
             return $role;

       }





       // delete role by admin
       public function delete(Request $request)
       {

        $user_id = Auth::user()->id;
        $table = $request->roles_id;
        foreach ($table as $t)
        {
            $id= ($t['role_id']);
            $role = Role::find($id);
            $role->delete();
            $activity = new ActivityLog();
            $activity->logSaver($user_id,'delete','role',$role->role_name);
        }
     
            return response()->json('was deleted');

       }

        //get role privs
       public function getRoleprivileges($id)
       {
            $role = Role::where('id',$id)->with('privilige')->get();
          return response()->json($role);

       }
}
