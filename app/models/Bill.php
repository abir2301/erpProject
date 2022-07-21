<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    protected $table = 'bills';
    protected $fillable = [
        'total_ttc','ht_price', 'rate_tva', 'price_tva',
        'fiscal_timber','billNum','bill_file','DateFacturation',
       'description' , 'client_id', 'inWord'
    ];


    protected $casts = [
        'DateFacturation' => 'datetime',
    ];
    public function item()
    {
        return $this->hasMany(Item::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class)->withTrashed();
    }

}
