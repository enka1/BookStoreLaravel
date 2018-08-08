<?php

namespace App\Http\Controllers;

use App\Book;
use App\BookSlider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class BookController extends Controller
{
    public function latest_arrived_book()
    {
        $books = Book::orderByDesc('on_shelf_time')->limit(36)->paginate(12);
        foreach ($books->items() as $book) {
            $book->author;
            $book->publisher;
            $book->description;
        }
        return $books;
    }

    public function index_latest_arrived_book()
    {
        $limit = Input::get('limit');
        $books = Book::orderBy('on_shelf_time')->limit($limit)->get();
        foreach ($books as $book) {
            $book->author;
            $book->publisher;
            $book->description;
        }
        return $books;
    }

    public function book_detail()
    {
        $book_id = Input::get('book_id');
        $book_detail = Book::findOrFail($book_id);
        $book_detail->author;
        $book_detail->publisher;
        return $book_detail;
    }

    public function random_book()
    {
        $sliders = BookSlider::orderBy(DB::raw('random()'))->limit(4)->get();
        foreach ($sliders as $item){
            $item->book;
        }
        return $sliders;
    }

    public function best_seller(){
        return Book::orderBy('price')->limit(3);
    }
}
