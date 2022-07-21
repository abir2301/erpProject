<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table ="tasks" ;
    protected $fillable =  [
        "task_name","progress","duration","predecessor","start_date",
        "end_date","parent_id","project_id"
    ] ;
    
    
 
    protected $casts = [
     'start_date' => 'datetime',
     'end_date' => 'datetime',
 ];
 
 public function subtasks()
{
    return $this->hasMany(Task::class , 'parent_id')->with('subtasks') ;
}
}
