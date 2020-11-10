<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;

    /**
     * @var string[] $fillable
     */
    protected $guarded = [];

    /**
     * Cast into Carbon instances.
     * @var string[] $dates
     */
    protected $dates = ['date_of_birth'];

    /**
     * Convert date_of_birth field to be instance of Carbon class
     * @param $dateOfBirth
     */
    public function setDateOfBirthAttribute($dateOfBirth)
    {
        $this->attributes['date_of_birth'] = Carbon::parse($dateOfBirth);
    }
}
