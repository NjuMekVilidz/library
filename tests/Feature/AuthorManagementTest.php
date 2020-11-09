<?php

namespace Tests\Feature;

use App\Models\Author;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthorManagementTest extends TestCase
{
    use RefreshDatabase;

    /** @test  */
    public function an_author_can_be_created()
    {
        $response = $this->post('/authors', [
            'name' => 'Author name',
            'date_of_birth' => '05/14/1988'
        ]);

        $author = Author::query()->first();

        $this->assertCount(1, Author::all());
        $response->assertRedirect($author->path());
        $this->assertInstanceOf(Carbon::class, $author->date_of_birth);
        $this->assertEquals('1988/14/05', $author->date_of_birth->format('Y/d/m'));
    }

    /** @test  */
    public function author_name_is_required()
    {
        $response = $this->post('/authors', [
           'name' => '',
           'date_of_birth' => '05/14/1998',
        ]);

        $response->assertSessionHasErrors('name');
    }

    /** @test  */
    public  function author_date_of_birth_is_required()
    {
        $response = $this->post('/authors', [
           'name' => 'Author name',
           'date_of_birth' => '',
        ]);

        $response->assertSessionHasErrors('date_of_birth');
    }

    /** @test */
    public  function  check_if_author_is_instance_of_model()
    {
        $this->post('/authors', [
           'name' => 'New Author',
           'date_of_birth' => '05/14/1998',
        ]);

        $author = Author::query()->first();

        $this->assertCount(1, Author::all());
        $this->assertInstanceOf(Model::class, $author);
    }
}
