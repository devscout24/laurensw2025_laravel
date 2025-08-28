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


/* {
    "status": true,
    "message": "Cruise details retrieved successfully",
    "data": {
        "id": 1,
        "external_id": "310",
        "name": "Arctic Odyssey",
        "length": 14,
        "ship_name": "M/v Sea Spirit",
        "destination": "Svalbard, Greenland & Iceland",
        "embarcation": "Longyearbyen (Svalbard)",
        "disembarkation": "Reykjavik (Iceland)",
        "start_date": "2025-09-03",
        "end_date": "2025-09-16",
        "url": "https://poseidonexpeditions.com/arctic/svalbard-east-greenland-iceland/310/",
        "map_route": "https://poseidonexpeditions.com/upload/iblock/03d/4c4yfprd9o04h39cnkn2q4qh9qo59wq5/map_Svalbard_East_Greenland_Iceland_EN (1).png",
        "days": [
            {
                "id": 1,
                "cruise_id": 1,
                "title": "Day 1 (Sept 3): Arrival in Longyearbyen, Svalbard (hotel night)",
                "text": "<p>the administrative center of Svalbard and starting point.</p>",
                "images": [
                    {
                        "id": 1,
                        "day_id": 1,
                        "image_url": "https://poseidonexpeditions.com/upload/iblock/1ad/tkhoudttkr8x1dd98y10ej23a0ly79qf/79.png",
                        "created_at": "2025-08-26T22:33:19.000000Z",
                        "updated_at": "2025-08-26T22:33:19.000000Z"
                    }
                ]
            },
            {
                "id": 2,
                "cruise_id": 1,
                "title": "Day 2 (Sept 4): Welcome Aboard!",
                "text": "<p>After breakfast at your hotel, the morning is yours to enjoy Longyearbyen.</p>",
                "images": [
                    {
                        "id": 3,
                        "day_id": 2,
                        "image_url": "https://poseidonexpeditions.com/upload/iblock/d69/ovfo3xnyvryiheyktntpmqvaangfqxv1/28.png",
                        "created_at": "2025-08-26T22:33:19.000000Z",
                        "updated_at": "2025-08-26T22:33:19.000000Z"
                    }
                ]
            },
        ],
        "cabins": [
             {
                "id": 1,
                "cruise_id": 2,
                "name": "Triple Suite",
                "price": "8195.00",
                "price_with_discount": "5327.00"
            },
            {
                "id": 2,
                "cruise_id": 2,
                "name": "Main Deck Suite",
                "price": "11295.00",
                "price_with_discount": "7342.00"
            },
        ],
        "highlights": [],
        "notes": [],
        "offers": []
    },
    "code": 200
} */
