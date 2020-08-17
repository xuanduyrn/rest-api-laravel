<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'description', 'price', 'nIdCategory'];
    public function category() {
        return $this->belongsTo('App\Categories', 'nIdCategory')->select('title', 'description');
    }
}
