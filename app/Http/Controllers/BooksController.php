<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookRequest;
use App\Models\Book;

class BooksController extends Controller
{
    /**
     * @param StoreBookRequest $request
     */
    public function store(StoreBookRequest $request)
    {
        Book::query()->create($request->all());
    }

    /**
     * @param StoreBookRequest $request
     * @param Book $book
     */
    public function update(StoreBookRequest $request, Book $book)
    {
        $book->update($request->all());
    }
}
