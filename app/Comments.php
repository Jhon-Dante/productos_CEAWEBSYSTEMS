<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    protected $table = "comments_products";
    protected $fillable=['id','commentary'];

    public function product() {
    	return $this->belongsTo('App\Products','product_id');
    }
}
