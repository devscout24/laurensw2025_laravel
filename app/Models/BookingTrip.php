<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Testing\Fluent\Concerns\Has;

class BookingTrip extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'trip_id',
        'ship_id',
        'cabin_id',
        'status',
        'total_amount',
        'number_of_members',
        'name',
        'surname',
        'gender',
        'date_of_birth',
        'mobile',
        'email',
        'street_house_number',
        'country',
        'post_code',
        'city_place_name',
        'stay_at_home_contact',
        'contact_no_home_caller',
        'room_preference',
        'travel_insurance',
        'insured_at',
        'policy_number',
        'additional_note',
        'terms_condition_check'
    ];

    // One booking belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // One booking belongs to a trip
    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }

    // One booking belongs to a ship
    public function ship()
    {
        return $this->belongsTo(Ship::class);
    }

    // One booking belongs to a cabin
    public function cabin()
    {
        return $this->belongsTo(Cabin::class);
    }
}
