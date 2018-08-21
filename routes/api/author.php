<?php
use App\Author;
Route::get('/author', function (){
    return Author::all();
});
