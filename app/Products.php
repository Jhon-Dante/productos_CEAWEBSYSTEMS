<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $table='products';
    protected $with = ['comments'];
    protected $fillable = ['name','price'];

    public function comments() {
    	return $this->hasMany('App\Comments','product_id');
    }
}
