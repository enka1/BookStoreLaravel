<?php
Route::get('/categories', function (){
    return \App\CategoryDetail::all();
});