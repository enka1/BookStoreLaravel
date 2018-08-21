<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    protected $table = 'author';
    protected $primaryKey = 'author_id';
    public $incrementing = false;
    protected $fillable = [
        'first_name',
        'last_name',
        'gender',
        'nationality',
        'description',
        'image_url'
    ];

    public function books(){
        return $this->hasMany('App\Book', 'author_id','author_id');
    }

}
