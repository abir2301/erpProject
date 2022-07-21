<?php

namespace App\Http\Controllers;

use App\models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
   


    public function addTask(Request $request)
    {
        // return $request ; 
        $task = new Task($request->task);
        $task->project_id = $request->project_id ;
        $task->save();
        return response()->json(["msg"=>"added!"]);
    }

    public function getTaskByproject($id)
    {
      
        $tasks = Task::where([['parent_id',NULL],['project_id',$id]])->with('subtasks')->get() ;
        return $tasks ; 
    }




    public function editTask(Request $request )
    {
        $task = Task::find($request->task_id);
        $task->update($request->newTask);
        $task->save();
        return response()->json(["msg"=>"updated!"]);
    }



    public function deleteTask(Request $request)
    {
        $task = Task::find($request->task_id);
        $task->delete();
        return response()->json(["msg"=>"deleted"]);
    }


    public function taskRelation(Request $request)
    {
        $task =  Task::find($request->task_id) ;
        $task->update([
            "parent_id" => $request->parent_id,
        ]);
        $task->save() ;
        return response()->json(["msg"=>"updated!!!!!!!"]);
    }


  

}
