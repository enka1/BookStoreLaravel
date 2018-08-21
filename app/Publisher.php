<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Publisher extends Model
{
    protected $table = 'publisher';
    protected $primaryKey = 'publisher_id';
    public $incrementing = false;
    protected $fillable = [
        'publisher_name',
        'description',
        'image_url'
    ];

    public function books()
    {
        return $this->hasMany('App\Book', 'publisher_id', 'publisher_id');
    }
}
