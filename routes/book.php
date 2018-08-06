<?php
/**
 * Created by PhpStorm.
 * User: Enka
 * Date: 8/5/2018
 * Time: 5:52 PM
 */
use Illuminate\Support\Facades\Route;

Route::get('/book/latest_arrived', 'BookController@latest_arrived_book');
