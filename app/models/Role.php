<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table ='roles' ;
    protected $fillable =[
        'role_name'
    ];



    
    public function privilige()
    {
        return $this->HasMany(Privilege::class) ;
    }
}
