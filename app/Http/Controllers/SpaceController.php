<?php

namespace App\Http\Controllers;

use App\models\Space;
use Illuminate\Http\Request;

class SpaceController extends Controller
{
    public function getSpaces()
    {
        $spaces = Space::all() ; 
        return $spaces ; 
    }
}
