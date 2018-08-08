<?php
/**
 * Created by PhpStorm.
 * User: Enka
 * Date: 8/5/2018
 * Time: 5:52 PM
 */

Route::get('/book/latest_arrived', 'BookController@latest_arrived_book');
Route::get('/book/index/latest_arrived', 'BookController@index_latest_arrived_book');
Route::get('/book/book_detail','BookController@book_detail');
Route::get('/book/random_book','BookController@random_book');
Route::get('/book/best_seller','BookController@best_seller');