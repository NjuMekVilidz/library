<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Cast into Carbon instances.
     * @var string[] $dates
     */
    protected $dates = ['checked_out_at', 'checked_in_at'];

    public function setCheckedOutAtAttribute($checkedOutAt)
    {
        $this->attributes['checked_out_at'] = Carbon::parse($checkedOutAt);
    }

    public function setCheckedInAtAttribute($checkedInAt)
    {
        $this->attributes['checked_in_at'] = Carbon::parse($checkedInAt);
    }
}
