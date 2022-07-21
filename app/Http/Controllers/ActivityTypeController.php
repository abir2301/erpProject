<?php



namespace App\Http\Controllers;

use App\models\ActivityType;
use App\models\ActivityLog;
use Illuminate\Http\Request;

class ActivityTypeController extends Controller
{




    public function test1(){
        $activityLog = new ActivityLog();
        $activityLog->test();
    }
}
