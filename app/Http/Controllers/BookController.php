<?php

namespace App\Http\Controllers;

use App\Book;
use Exception;
use Illuminate\Support\Facades\Input;
use App\Categories;
use App\Publisher;
use App\Author;


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

    public function add_new_book(){
        try {
            \DB::beginTransaction();
            $book_data = Input::get('book');
            $author = Author::find($book_data['author_id']);
            $publisher = Publisher::find($book_data['publisher_id']);
            $new_book = new Book([
                'book_id' => \DB::select('select uuid_generate_v4() as book_id')[0]->book_id,
                'book_name' => $book_data['book_name'],
                'image_url' => $book_data['book_img'],
                'on_shelf_time' => $book_data['on_shelf_time'],
                'description' => $book_data['description'],
                'import_price' => $book_data['import_price'],
                'sale_price' => $book_data['sale_price']
            ]);
            $new_book->author()->associate($author);
            $new_book->publisher()->associate($publisher);
            $new_book->save();
            $categories = 'Array[';
            foreach ($book_data['categories'] as $category_id) {
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
}
