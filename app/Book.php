<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $table = 'book';
    public $incrementing = false;
    protected $primaryKey = 'book_id';
    public $timestamps = false;
    protected $fillable = [
        'book_name',
        'import_price',
        'sale_price',
        'description',
        'image_url',
        'on_shelf_time',
        'quantity',
        'on_sale'
    ];

    public function author()
    {
        return $this->belongsTo('App\Author', 'author_id', 'author_id');
    }

    public function publisher()
    {
        return $this->belongsTo('App\Publisher', 'publisher_id', 'publisher_id');
    }

    public function categories()
    {
        return $this->hasOne('App\Categories', 'book_id', 'book_id');
    }

    public function slider()
    {
        return $this->hasOne('App\BookSlider', 'book_id', 'book_id');
    }

    public function find_by_book_name($book_name)
    {
        return $this::where('book_name', 'ilike', '%' . $book_name . '%')->get();
    }

    public function book_detail($book_id)
    {
        $book_detail = $this::find($book_id);
        $book_detail->author;
        $book_detail->publisher;
        $book_detail->categories;
        return $book_detail;
    }

    public function get_storage_state()
    {
        $books = $this::orderBy('book_name')->paginate(10);
        foreach ($books as $book) {
            $book->author;
            $book->publisher;
        }
        return $books;
    }

    public function get_book_sliders()
    {
        return $this::has('slider')->with('slider')->orderBy(\DB::raw('random()'))->get();
    }

    public function book_collection_by_genres($genres, $isAsc, $sortBy)
    {
        if ($genres != null && sizeof($genres) > 0) {
            $books = Book::whereHas('categories', function ($book) use ($genres) {
                $genresDB = "ARRAY[";
                foreach ($genres as $genre) {
                    $genresDB = $genresDB . "'" . $genre . "',";
                }
                $genresDB = substr($genresDB, 0, -1) . ']::uuid[]';
                $book->where('categories', '@>', \DB::raw($genresDB));
            });
        } else {
            $books = Book::with('categories');
        }
        if ($isAsc == true) {
            $books->orderBy($sortBy)->get();
        } else {
            $books->orderByDesc($sortBy)->get();
        }
        $books = $books->paginate(16);
        foreach ($books->items() as $book) {
            $book->author;
            $book->publisher;
        }
        return $books;
    }
}
