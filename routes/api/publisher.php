<?php
use App\Publisher;
Route::get('/publishers', function (){
    return Publisher::all();
});