<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class MailContent extends Model
{
            protected $table= "mail_contents";
            protected $fillable = [
                'subject','content'
            ] ;
}
