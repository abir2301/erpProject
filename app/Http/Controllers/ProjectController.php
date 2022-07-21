<?php

namespace App\Http\Controllers;
use App\models\User;
use Illuminate\Support\Facades\Auth ;
use App\models\Project;
use App\models\ActivityLog;
use App\models\Action;
use App\models\Space;
use Illuminate\Http\Request;

class ProjectController extends Controller
{

            // create new project By admin
            public function create(Request $request)
            {
                            $user_id = Auth::user()->id ;
                            $project = new Project($request->project);
                            $project->creator_id = $user_id;
                            $project->start_date = $project->start_date->addHour();
                            $project->save();

                            $activity = new ActivityLog();
                            $activity->logSaver($user_id,'create','project',$project->project_name);
                            return response()->json(['message'=>'created','project'=>$project]) ;
            }



            // update Project by user&admin
            public function update(Request $request)
            {
                $user_id = Auth::user()->id ;
                $project_id=$request->project_id ; 
                $project = Project::find($project_id);
                $project->update($request->newProject);
                $project->save();

                $activity = new ActivityLog();
                $activity->logSaver($user_id,'update','project',$project->project_name);
                return response()->json(['message'=>'updated','project'=>$project]) ;
            }

            


            // get user projects
            public function getUserProjects($id)
            {

                $project = Project::where('creator_id',$id)->get();


                if(is_null($project))
                {
                    return response()->json(["message"=> "not found"]);
                }

                return $project ;
            }

            //get all project for admin
            public function getAllProjects()
            {
                $projects = Project::with('paper')->get() ;
                return $projects ;
            }


            // get Project By id
            public function getProjectById($id)
            {
                $project = Project::find($id);
                return $project ;
            }

            // delete project by admin
            public function delete(Request $request)

            {
                $user_id = Auth::user()->id;
                $table = $request->projects;
                foreach ($table as $t)
                {
                    $id= ($t['project_id']);
                    $project = Project::find($id);
                    $project->delete();
                    $activity = new ActivityLog();
                    $activity->logSaver($user_id,'delete','project',$project->project_name);
                }
                

                return response()->json(['message'=>'Deleted']) ;


            }

            //get project papers
            public function paperProject($id){
                $project = Project::Where('id',$id)->with('paper')->get();
                return $project;
            }




            //get project with client
            public function getProjectsWithinfo()
            {
                $projects = Project::with('client','paper.paperType')->get();
                return $projects;
            }
}
