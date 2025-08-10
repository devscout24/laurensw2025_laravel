<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookingTrip extends Model
{
    use SoftDeletes;
    protected $table = 'booking_trips';
}
