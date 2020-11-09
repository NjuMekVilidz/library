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
        $book = Book::query()->create($request->all());

        return redirect($book->path());
    }

    /**
     * @param StoreBookRequest $request
     * @param Book $book
     */
    public function update(StoreBookRequest $request, Book $book)
    {
        $book->update($request->all());

        return redirect($book->path());
    }

    public function destroy(Book $book)
    {
        $book->delete();

        return redirect('/books');
    }
}
