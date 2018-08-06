<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'category';
    protected $primaryKey = 'category_id';
    public $incrementing = false;
    protected $fillable = [
        'category_name',
        'description'
    ];
    public function book(){
        $this->belongsToMany('App\Book','book_category','category_id','book_id');
    }
}
