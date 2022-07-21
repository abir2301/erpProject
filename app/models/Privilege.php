<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Privilege extends Model
{
    protected $table ="privileges";
    protected $fillable = [
    'role_id','space_id','action_id'
    ] ;



    public function action()
    {
        return $this->belongsTo(Action::class);
    }

    public function space()
    {
        return $this->belongsTo(Space::class);
    }
   



    
}
