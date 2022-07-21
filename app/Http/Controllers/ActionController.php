<?php

namespace App\Http\Controllers;

use App\models\Action;
use Illuminate\Http\Request;

class ActionController extends Controller
{



    public function getActions()
    {
        $actions = Action::all() ; 
        return $actions ; 
    }
}
