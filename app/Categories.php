<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    protected $table = 'dat_categories'; // Từ chối hiểu
    protected $primaryKey = 'nIdCategory';
    protected $fillable = ['title', 'description'];

    public function products() {
        return $this->hasMany('App\Product', 'nIdCategory', 'nIdCategory')->get();
    }
}
