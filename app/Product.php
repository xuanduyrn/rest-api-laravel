<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'description', 'price', 'nIdCategory'];

    // public function getCreatedAtAttribute($date) {
    //     return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('Y-m-d')->toDateTimeString();
    // }

    // public function getUpdatedAtAttribute($date) {
    //     return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('Y-m-d')->toDateTimeString();
    // }
    
    const CREATED_AT = 'create_time';
    const UPDATED_AT = 'update_time'; 

    public function category() {
        return $this->belongsTo('App\Categories', 'nIdCategory')->select('title', 'description');
    }
}
