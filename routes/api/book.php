<?php
/**
 * Created by PhpStorm.
 * User: Enka
 * Date: 8/5/2018
 * Time: 5:52 PM
 */

Route::get('/books/book-detail/{id}', 'BookController@find_by_id');
Route::get('/books/slider', 'BookController@get_book_sliders');

Route::post('/books/search', 'BookController@find_by_name');
Route::post('/books/delete-book', 'BookController@delete_book');
Route::post('/books/by_genre', 'BookController@book_collection_by_genres');
Route::post('/admin/add-new-book', 'BookController@add_new_book');
Route::post('/admin/update-book', 'BookController@update_book');
//admin route
Route::get('/admin/storage', 'BookController@get_storage_state');

