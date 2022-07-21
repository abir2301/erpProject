<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
     protected $table = "companies";
     protected $fillable = [
         'name','local','email','logo','domaine','mat_fiscal',
         'bank_name','phone_number','employee_number','tax','tva','sendTo'
     ] ;
}
