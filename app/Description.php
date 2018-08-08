<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Description extends Model
{
     protected $table = 'book_description';
     protected $primaryKey = 'description_id';
     public $incrementing = false;
     function book(){
         return $this->belongsTo('App\Book','book_id','book_id');
     }
}
