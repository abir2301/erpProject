<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'contact_name', 'contact_email', 'description','contact_phone','client_id'
        , 'position'
    ];
}
