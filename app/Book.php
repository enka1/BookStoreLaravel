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
        'book_id',
        'book_name',
        'price',
        'author_id',
        'image_url',
        'on_shelf_time',
        'quantity',
        'on_sale'
    ];

    public function author()
    {
        return $this->belongsTo('App\Author', 'author_id', 'author_id');
    }

    public function publisher()
    {
        return $this->belongsTo('App\Publisher', 'publisher_id', 'publisher_id');
    }

    public function categories()
    {
        return $this->hasOne('App\Categories', 'book_id', 'book_id');
    }

    public function description()
    {
        return $this->hasMany('App\Description', 'book_id', 'book_id');
    }

    public function slider()
    {
        return $this->hasOne('App\BookSlider', 'book_id', 'book_id');
    }


}
