<?php

namespace App\Http\Controllers;

use App\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function latest_arrived_book(Request $request)
    {
        return Book::paginate(10);
    }
}
