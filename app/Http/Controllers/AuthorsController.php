<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAuthorRequest;
use App\Models\Author;

class AuthorsController extends Controller
{
    public function store(StoreAuthorRequest $request)
    {
        $author = Author::query()->create($request->all());

        return redirect('/authors/' . $author->id);
    }
}
