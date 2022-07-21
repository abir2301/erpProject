<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $table = 'projects' ; 
    protected $fillable = [
        'project_name', 'description', 'status','start_date','client_id','end_date'
    ];


    public function paper()
    {
        return $this->HasMany(Paper::class) ;
    }
    public function client()
    {
        return $this->belongsTo(Client::class)->withTrashed() ;
    }




    protected $casts = [
        'start_date' => 'datetime',
    ];
}
