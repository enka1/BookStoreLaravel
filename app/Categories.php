<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    protected $table = 'book_category';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = [
        'categories',
        'book_id'
    ];

    public function books()
    {
        return $this->belongsTo('App\Book', 'book_id', 'book_id');
    }
}
