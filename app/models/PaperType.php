<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaperType extends Model
{
    use SoftDeletes;
    protected $fillable = [
         'paper_type', 'email_id','is_renewing'
    ];



    public function paper()
    {
        return $this->hasMany(Paper::class ,'paper_type');
    }


    public function email()
    {
        return $this->belongsTo(MailContent::class) ;
    }
}
