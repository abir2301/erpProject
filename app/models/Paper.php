<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Paper extends Model
{
    protected $fillable = [
        'paper_file','paper_name', 'description', 'start_date','end_date','isReminded',
        'auto_email','project_id','paper_type','status','alert_date'
    ];



  


    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'alert_date' => 'datetime',
    ];


    public function paperType()
    {
        return $this->belongsTo(PaperType::class, 'paper_type')->withTrashed();
    }
    
    public function project()
    {
        return $this->belongsTo(Project::class);

    }

    public function type()
    {
        return $this->belongsTo(PaperType::class, 'paper_type')->where('is_renewing',1)->withTrashed();
    }

  


  
}
