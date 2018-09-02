<?php

namespace App\Http\Controllers;

use App\Book;
use App\Categories;
use App\Publisher;
use App\Author;
use Exception;
use Illuminate\Support\Facades\Input;

class BookController extends Controller
{
    private $model;

    /**
     * BookController constructor.
     */
    public function __construct()
    {
        $this->model = new Book();
    }

    public function find_by_name()
    {
        return $this->model->find_by_book_name(Input::get('book_name'));
    }

    public function find_by_id($id)
    {
        return $this->model->book_detail($id);
    }

    public function get_storage_state()
    {
        return $this->model->get_storage_state();
    }

    public function get_book_sliders()
    {
        return $this->model->get_book_sliders();
    }

    public function book_collection_by_genres()
    {
        $genres = Input::get('genres');
        $isAsc = Input::get('isAsc');
        $sortBy = Input::get('sortBy');
        return $this->model->book_collection_by_genres($genres, $isAsc, $sortBy);
    }

    public function add_new_book()
    {
        try {
            \DB::beginTransaction();
            $author = Author::find(Input::get('author_id'));
            $publisher = Publisher::find(Input::get('publisher_id'));
            $new_book = new Book(Input::all());
            $new_book->book_id = \DB::select('select uuid_generate_v4() as book_id')[0]->book_id;
            $new_book->author()->associate($author);
            $new_book->publisher()->associate($publisher);
            $new_book->save();
            $categories = 'Array[';
            foreach (Input::get('categories') as $category_id) {
                $categories = $categories . "'" . $category_id . "',";
            }
            $categories = substr($categories, 0, -1) . ']::uuid[]';
            $new_book->categories()->save(new Categories([
                'categories' => \DB::raw($categories)
            ]));
            \DB::commit();
            return ['status' => 'success'];
        } catch (Exception $exception) {
            \DB::rollBack();
            return ['status' => 'fail', 'error' => $exception->getMessage()];
        }
    }

    public function update_book()
    {
        try {
            \DB::beginTransaction();
            $book = Book::find(Input::get('book_id'));
            $author = Author::find(Input::get('author_id'));
            $publisher = Publisher::find(Input::get('publisher_id'));
            $book->author()->associate($author);
            $book->publisher()->associate($publisher);
            $book->fill(Input::all());
            $book->save();
            $categoriesDB = 'Array[';
            foreach (Input::get('categories') as $category_id) {
                $categoriesDB = $categoriesDB . "'" . $category_id . "',";
            }
            $categoriesDB = substr($categoriesDB, 0, -1) . ']::uuid[]';
            $book->categories()->delete();
            $book->categories()->save(new Categories(['categories'=>\DB::raw($categoriesDB)]));
            \DB::commit();
            return ['status' => 'success'];
        } catch (Exception $exception) {
            \DB::rollBack();
            return ['status' => 'fail', 'error' => $exception->getMessage()];
        }
    }

    public function delete_book(){
        $books = Book::findMany([Input::get('book_id')]);
        foreach ($books as $book){
            $book->delete();
        }
        return ['status' => 'success'];
    }
}


