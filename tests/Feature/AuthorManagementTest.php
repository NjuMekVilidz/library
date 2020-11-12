<?php

namespace Tests\Feature;

use App\Models\Author;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthorManagementTest extends TestCase
{
    use RefreshDatabase;

    /** @test  */
    public function an_author_can_be_created()
    {
        $this->post('/authors', $this->data());

        $authors = Author::all();

        $this->assertCount(1, $authors);
        $this->assertInstanceOf(Carbon::class, $authors->first()->date_of_birth);
        $this->assertEquals('1988/14/05', $authors->first()->date_of_birth->format('Y/d/m'));
    }

    /** @test  */
    public function author_name_is_required()
    {
        $response = $this->post('/authors', array_merge($this->data(), ['name' => '']));

        $response->assertSessionHasErrors('name');
    }

    /** @test  */
    public  function author_date_of_birth_is_required()
    {
        $response = $this->post('/authors', array_merge($this->data(), ['date_of_birth' => '']));

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

    private function data()
    {
        return [
          'name' => 'Author name',
          'date_of_birth' => '05/14/1988',
        ];
    }
}
