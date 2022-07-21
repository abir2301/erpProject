<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use App\models\Action;
use App\models\Space;
class ActivityLog extends Model
{
    protected $table ='activity_logs';
    protected $fillable =[
        'user_id', 'action_id','space_id','service_name'
    ];



    public function logSaver($id,$action_name,$space_name,$serv_name)
    {

        $action = Action::where('action_name',$action_name)->first();
        $space  = Space::where('space_name',$space_name)->first();
        $action_id = $action->id;
        $space_id  = $space->id;

        $activity = ActivityLog::create([
            'user_id'=>  $id ,
            'action_id'=> $action_id,
            'space_id'=> $space_id,
            'service_name'=>  $serv_name,
         ]);
        }

         
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function space()
    {
        return $this->belongsTo(Space::class);
    }
    public function action()
    {
        return $this->belongsTo(Action::class);
    }
}
