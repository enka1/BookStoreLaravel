<?php
/**
 * Created by PhpStorm.
 * User: Enka
 * Date: 8/5/2018
 * Time: 5:52 PM
 */

use App\Book;
use App\BookSlider;
use Illuminate\Support\Facades\Input;
use App\Author;
use App\Publisher;
use App\Categories;

Route::get('/books/latest_arrived', function () {
    $books = Book::orderByDesc('on_shelf_time')->paginate(12);
    foreach ($books->items() as $book) {
        $book->author;
        $book->publisher;
        $book->description;
    }
    return $books;
});

Route::get('/books/by_genre', function () {
    if (Input::get('genres') !== null and sizeof(Input::get('genres')) > 0) {
        $books = Book::whereHas('categories', function ($book) {
            $genresDB = "ARRAY[";
            foreach (Input::get('genres') as $genre) {
                $genresDB = $genresDB . "'" . $genre . "',";
            }
            $genresDB = substr($genresDB, 0, -1) . ']::uuid[]';
            $book->where('categories', '@>', DB::raw($genresDB));
        });
        if (Input::get('isAsc') == true) {
            $books->orderBy(Input::get('sortBy'));
        } else {
            $books->orderByDesc(Input::get('sortBy'));
        }
        $books = $books->paginate(12);
        foreach ($books->items() as $book) {
            $book->author;
            $book->description;
            $book->publisher;
        }
        return $books;
    } else {
        if (Input::get('isAsc') === 'true') {
            $books = Book::orderBy(Input::get('sortBy'));
        } else {
            $books = Book::orderByDesc(Input::get('sortBy'));
        }
        $books = $books->paginate(12);
        foreach ($books->items() as $book) {
            $book->author;
            $book->description;
            $book->publisher;
        }
        return $books;
    }
});

Route::get('/books/book_detail', function () {
    $book_id = Input::get('book_id');
    $book_detail = Book::find($book_id);
    $book_detail->author;
    $book_detail->publisher;
    return $book_detail;
});

Route::get('/books/book_slider', function () {
    $sliders = BookSlider::orderBy(DB::raw('random()'))->limit(4)->get();
    foreach ($sliders as $item) {
        $item->book;
    }
    return $sliders;
});

Route::get('/admin/storage', function () {
    $books = Book::orderBy('book_name')->paginate(10);
    foreach ($books as $book) {
        $book->author;
        $book->publisher;
    }
    return $books;
});

Route::post('/admin/add-new-book', function () {
    $author = Author::find(Input::get('author_id'));
    $publisher = Publisher::find(Input::get('publisher_id'));
    $new_book = new Book([
        'book_id' => DB::select('select uuid_generate_v4() as book_id')[0]->book_id,
        'book_name' => Input::get('book_name'),
        'image_url' => Input::get('image_url'),
        'on_shelf_time' => Input::get('on_shelf_time')
    ]);
    $new_book->author()->associate($author);
    $new_book->publisher()->associate($publisher);
    $new_book->save();
    $categories = 'Array[';
    foreach (Input::get('categories') as $category_id) {
        $categories = $categories . "'" . $category_id . "',";
    }
    $categories = substr($categories, 0, -1) . ']::uuid[]';
    $new_book->categories()->save(new Categories([
        'categories' => DB::raw($categories)
    ]));
    return $new_book;
});