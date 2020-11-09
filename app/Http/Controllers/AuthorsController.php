<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAuthorRequest;
use App\Models\Author;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class AuthorsController extends Controller
{
    /**
     * @param StoreAuthorRequest $request
     * @return Application|RedirectResponse|Redirector
     */
    public function store(StoreAuthorRequest $request)
    {
        $author = Author::query()->create($request->all());

        return redirect($author->path());
    }
}
