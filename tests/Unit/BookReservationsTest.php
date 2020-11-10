<?php

namespace Tests\Unit;

use App\Models\Book;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookReservationsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_book_can_be_checked_out()
    {
        $book = Book::factory()->create();
        $user = User::factory()->create();

        $book->checkout($user);

        $this->assertCount(1, Reservation::all());
        $this->assertEquals($user->id, Reservation::query()->first()->user_id);
        $this->assertEquals($book->id, Reservation::query()->first()->book_id);
        $this->assertEquals(now()->format('Y/d/m'), Reservation::query()->first()->checked_out_at->format('Y/d/m'));
    }

    /** @test */
    public function a_book_can_be_returned()
    {
        $book = Book::factory()->create();
        $user = User::factory()->create();
        $book->checkout($user);

        $book->checkin($user);

        $this->assertCount(1,Reservation::all());
        $this->assertEquals($user->id, Reservation::query()->first()->user_id);
        $this->assertEquals($book->id, Reservation::query()->first()->book_id);
        $this->assertNotNull(Reservation::query()->first()->checked_in_at);
        $this->assertEquals(now()->format('Y/d/m'), Reservation::query()->first()->checked_in_at->format('Y/d/m'));
    }

    // If not checked out, then exception
    /** @test  */
    public function if_not_checked_out_exception_is_thrown()
    {
        $this->expectException(\Exception::class);

        $book = Book::factory()->create();
        $user = User::factory()->create();

        $book->checkin($user);
    }

    // a user can check out a book twice
    /** @test */
    public function a_user_can_check_out_a_book_twice()
    {
        $book = Book::factory()->create();
        $user = User::factory()->create();
        $book->checkout($user);
        $book->checkin($user);

        $book->checkout($user);
        $reservation = Reservation::query()->find('3');

        $this->assertCount(2,Reservation::all());
        $this->assertEquals($user->id, $reservation->user_id);
        $this->assertEquals($book->id, $reservation->book_id);
        $this->assertNotNull($reservation->checked_in_at->format('Y/d/m'));
        $this->assertEquals(now()->format('Y/d/m'), $reservation->checked_out_at->format('Y/d/m'));

        $book->checkin($user);

        $this->assertCount(2,Reservation::all());
        $this->assertEquals($user->id, Reservation::query()->find(4)->user_id);
        $this->assertEquals($book->id, Reservation::query()->find(4)->book_id);
        $this->assertNotNull(Reservation::query()->find(4)->checked_in_at->format('Y/d/m'));
        $this->assertEquals(now()->format('Y/d/m'), Reservation::query()->find(4)->checked_in_at->format('Y/d/m'));
    }
}
