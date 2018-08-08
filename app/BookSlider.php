<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookSlider extends Model
{
    public $incrementing = false;
    protected $primaryKey = 'id';
    protected $table = 'book_slider';

    public function book()
    {
        return $this->belongsTo('App\Book', 'book_id', 'book_id');
    }
}
