<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $table = 'book';
    public $incrementing = false;
    protected $primaryKey = 'book_id';
    public $timestamps = false;
    protected $fillable = [
        'book_name',
        'author_id',
        'publisher_id',
        'price',
        'image_url',
        'on_shelf_time',
        'quantity',
        'on_sale'
    ];

    public function author()
    {
        return $this->hasOne('App\Author', 'author_id', 'author_id');
    }

    public function publisher()
    {
        return $this->hasOne('App\Publisher', 'publisher_id', 'publisher_Id');
    }

    public function category()
    {
        return $this->belongsToMany('App\Category', 'book_category', 'book_id', 'category_id');
    }


}
