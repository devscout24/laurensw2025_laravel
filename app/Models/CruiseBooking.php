<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CruiseBooking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'cruise_id',
        'cruise_cabin_id',
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
        'terms_condition_check',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cruise()
    {
        return $this->belongsTo(Cruise::class, 'cruise_id');
    }


    public function cabin()
    {
        return $this->belongsTo(CruiseCabin::class, 'cruise_cabin_id');
    }
}
