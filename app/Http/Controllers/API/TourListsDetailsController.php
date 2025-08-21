<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;


class TourListsDetailsController extends Controller
{
    public function getApiOne(Request $request)
    {
        // Validation for query params
        $validated = $request->validate([
            'page' => 'integer|min:1',
            'per_page' => 'integer|min:1|max:50',
        ]);

        $page = $validated['page'] ?? 1;
        $perPage = $validated['per_page'] ?? 10;

        // API URL (no pagination, it returns all data)
        $url = "https://api.heritage-expeditions.com/v1/trips";

        // API call
        $response = Http::withHeaders([
            'Authorization' => 'Bearer e7f289d1f7c60022d38b1ed28bcb8212e5d02882',
            'Accept' => 'application/json',
        ])->get($url);

        if ($response->successful()) {
            // Convert all data into collection
            $data = collect($response->json());

            // Laravel internal pagination
            $paginated = new LengthAwarePaginator(
                $data->forPage($page, $perPage), // slice only needed items
                $data->count(),                 // total items
                $perPage,
                $page,
                ['path' => $request->url(), 'query' => $request->query()]
            );

            return response()->json($paginated, 200);
        }

        return response()->json([
            'error' => 'Failed to fetch data',
            'status' => $response->status(),
            'message' => $response->body()
        ], $response->status());
    }
}

/* {
    "current_page": 1,
    "data": [
        {
            "id": 1987,
            "trip_id": 609,
            "name": "In the Wake of Scott & Shackleton",
            "subtitle": "Ross Sea Antarctica",
            "departure_date": "2027-02-01",
            "return_date": "2027-02-28",
            "highlights": "Visit Antarctica's Ross Sea on this 28-day expedition which also includes the New Zealand Subantarctic Islands and Australia's Macquarie Island. There is much to see and do, visit penguin rookeries,
            "code": "HA270201",
            "availablity": "Available",
            "availability": "Available",
            "feature_image": "https://heritage-expeditions.com/media/uploads/banner-trip-ross-sea-adelies-heritage-expeditions.jpg",
            "brochure": null,
            "starting_city": "Queenstown",
            "finishing_city": "Queenstown",
            "starting_point": "Queenstown",
            "finishing_point": "Queenstown",
            "duration": 28,
            "includes": "<p>Landing fees, pre/post cruise transfers, one night hotel accommodation in a twin share room (incl. dinner/breakfast), all on board ship accommodation with meals,&nbsp;house beer, wine and soft drinks with lunch and dinner and all shore excursions and activities. Programme of lectures by noted naturalists.</p>",
            "excludes": "<p>All items of a personal nature, laundry, drinks, gratuities, kayaking excursion. International/domestic flights, visas and travel insurance.</p>",
            "additional_fees": {
                "amount": null,
                "currency": "USD",
                "name": ""
            },
            "non_commissionable_amount": [
                {
                    "amount": "1750.00",
                    "currency": "AUD"
                },
                {
                    "amount": "1155.00",
                    "currency": "USD"
                },
                {
                    "amount": "900.00",
                    "currency": "GBP"
                },
                {
                    "amount": "1900.00",
                    "currency": "NZD"
                },
                {
                    "amount": "1110.00",
                    "currency": "EUR"
                }
            ],
            "ship": {
                "id": 24,
                "name": "Heritage Adventurer",
                "description": "<p><em>Heritage Adventurer</em> is a true pioneering expedition vessel of exceptional pedigree. Often referred to as the 'Grande Dame of Expedition Cruising' due to her celebrated history and refined design, she was purpose-built for adventure in 1991 at Finland's Rauma shipyard and specifically designed for Polar exploration.</p>\r\n<p>Setting a peerless standard in authentic expedition travel, <em>Heritage Adventurer</em> (formerly known as <em>MS Hanseatic</em>) combines the highest passenger ship iceclass rating (1A Super) with an impressive history of Polar exploration. Having held records for the most northern and southern Arctic and Antarctic navigations, and for traversing both the Northwest and Northeast Passages, makes <em>Heritage Adventurer</em> perfect for pioneering New Zealand-based Heritage Expeditions signature experiential expedition travel.</p>\r\n<p>Originally designed to accommodate 184 guests, <em>Heritage Adventurer</em> now welcomes just 140 expeditioners ensuring spacious, stylish and comfortable voyages, while a fleet of 14 Zodiacs ensures all guests are able to maximise their expedition adventure. <em>Heritage Adventurer</em> proudly continues our traditions of exceptional, personalised expedition experiences as Heritage Expeditions flagship.</p>",
                "feature_image": "https://heritage-expeditions.com/media/uploads/heritage_adventurer/heritage_adventurer_at_fiordlands_s.bradley.jpg",
                "cabin_layout_image": "https://heritage-expeditions.com/media/uploads/heritage_adventurer/deck_plan_heritage_adventurer.jpg",
                "last_known_location": {
                    "long": 130.4596953,
                    "lat": -12.317184,
                    "last_updated": "2025-08-22T06:00:02.928375"
                },
                "ship_specs": [
                    {
                        "name": "Year Built",
                        "value": "1991"
                    },
                    {
                        "name": "Shipyard",
                        "value": "Rauma, Finland"
                    },
                    {
                        "name": "Classification",
                        "value": "Lloyds 1AS, GL E4"
                    },
                    {
                        "name": "Accommodation",
                        "value": "140 guests"
                    },
                    {
                        "name": "Length",
                        "value": "124 metres"
                    },
                    {
                        "name": "Beam",
                        "value": "18 metres"
                    },
                    {
                        "name": "Draft",
                        "value": "4.97 metres"
                    },
                    {
                        "name": "Gross Tonnage",
                        "value": "8,378gt"
                    },
                    {
                        "name": "Engines",
                        "value": "3,940 horsepower (x2)"
                    },
                    {
                        "name": "Maximum Speed",
                        "value": "15 knots"
                    },
                    {
                        "name": "Cruising Speed",
                        "value": "12 knots"
                    },
                    {
                        "name": "Range",
                        "value": "8,600 nautical miles"
                    },
                    {
                        "name": "Zodiacs",
                        "value": "14"
                    }
                ],
                "gallery": [
                    "https://heritage-expeditions.com/media/uploads/heritage_adventurer/ha_bridge_captain_hans_d.brown.jpg",
                    "https://heritage-expeditions.com/media/uploads/heritage_adventurer/jacuzzi_f.wardle.jpg",
                    "https://heritage-expeditions.com/media/uploads/ha_dining_room_captain_f.wardle.jpg",
                    "https://heritage-expeditions.com/media/uploads/heritage_adventurer/heritage_adventurer_aerial_ewen_bell.jpg",
                    "https://heritage-expeditions.com/media/uploads/heritage_adventurer/bathroom.jpg",
                    "https://heritage-expeditions.com/media/uploads/heritage_adventurer/sauna_f.wardle.jpg",
                    "https://heritage-expeditions.com/media/uploads/heritage_adventurer/heritage_adventurer_zodiac_ewen_bell.jpg",
                    "https://heritage-expeditions.com/media/uploads/heritage_adventurer/pool_deck_f.wardle.jpg",
                    "https://heritage-expeditions.com/media/uploads/heritage_adventurer/outside_observation_deck.jpg",
                    "https://heritage-expeditions.com/media/uploads/heritage_adventurer/dining.jpg",
                    "https://heritage-expeditions.com/media/uploads/heritage_adventurer/library.jpg",
                    "https://heritage-expeditions.com/media/uploads/heritage_adventurer/heritage_adventurer_breakfast_ewen_bell.jpg",
                    "https://heritage-expeditions.com/media/uploads/heritage_adventurer/deck_5_superior_dana_brown.jpg",
                    "https://heritage-expeditions.com/media/uploads/heritage_adventurer/gym.jpg",
                    "https://heritage-expeditions.com/media/uploads/heritage_adventurer/heritage_suite_3_dana_brown.jpg",
                    "https://heritage-expeditions.com/media/uploads/heritage_adventurer/bistro_outside.jpg",
                    "https://heritage-expeditions.com/media/uploads/heritage_adventurer/heritage_adventurer_pool_2.jpg",
                    "https://heritage-expeditions.com/media/uploads/heritage_adventurer/heritage_adventurer_sunset_ewen_bell.jpg",
                    "https://heritage-expeditions.com/media/uploads/heritage_adventurer/superior_single_s.bradley%2Ckimberley_edited.png",
                    "https://heritage-expeditions.com/media/uploads/heritage_adventurer/heritage_adventurer1_n.russ.jpg",
                    "https://heritage-expeditions.com/media/uploads/heritage_adventurer/heritage_adventurer_dining_room_ewen_bell.jpg",
                    "https://heritage-expeditions.com/media/uploads/heritage_adventurer/jacuzzi_2.jpg",
                    "https://heritage-expeditions.com/media/uploads/heritage_adventurer/heritage_adventurer_loung_ewen_bell.jpg",
                    "https://heritage-expeditions.com/media/uploads/heritage_adventurer/ha_bistro_d.brown.jpg",
                    "https://heritage-expeditions.com/media/uploads/heritage_adventurer/heritage_adenturer_observation_loungeewen_bell.jpg",
                    "https://heritage-expeditions.com/media/uploads/heritage_adventurer/heritage_adventurer__poolside_ewen_bell.jpg",
                    "https://heritage-expeditions.com/media/uploads/heritage_adventurer/ha_bar_d.brown.jpg",
                    "https://heritage-expeditions.com/media/uploads/heritage_adventurer/stateroom_lounge_ewen_bell.jpg",
                    "https://heritage-expeditions.com/media/uploads/heritage_adventurer/watching_on_deck.jpg",
                    "https://heritage-expeditions.com/media/uploads/heritage_adventurer/dining_room_ewen_bell.jpg"
                ]
            },
            "trip_map": {
                "route": [
                    {
                        "long": 168.33904,
                        "lat": -46.58088
                    },
                    {
                        "long": 168.35415,
                        "lat": -46.59126
                    },
                    {
                        "long": 168.35415,
                        "lat": -46.59126
                    },
                    {
                        "long": 168.35895,
                        "lat": -46.60353
                    },
                    {
                        "long": 168.35895,
                        "lat": -46.60353
                    },
                    {
                        "long": 168.36994,
                        "lat": -46.61438
                    },
                    {
                        "long": 168.36994,
                        "lat": -46.61438
                    },
                    {
                        "long": 168.27372,
                        "lat": -47.10089
                    },
                    {
                        "long": 168.27372,
                        "lat": -47.10089
                    },
                    {
                        "long": 166.60843,
                        "lat": -48.01096
                    },
                    {
                        "long": 166.60843,
                        "lat": -48.01096
                    },
                    {
                        "long": 166.61084,
                        "lat": -48.0174
                    },
                    {
                        "long": 166.61084,
                        "lat": -48.0174
                    },
                    {
                        "long": 166.61564,
                        "lat": -48.0205
                    },
                    {
                        "long": 166.61564,
                        "lat": -48.0205
                    },
                    {
                        "long": 166.61599,
                        "lat": -48.02463
                    },
                    {
                        "long": 166.61599,
                        "lat": -48.02463
                    },
                    {
                        "long": 166.61891,
                        "lat": -48.02922
                    },
                    {
                        "long": 166.61891,
                        "lat": -48.02922
                    },
                    {
                        "long": 166.61719,
                        "lat": -48.0376
                    },
                    {
                        "long": 166.61719,
                        "lat": -48.0376
                    },
                    {
                        "long": 166.33494,
                        "lat": -50.49284
                    },
                    {
                        "long": 166.33494,
                        "lat": -50.49284
                    },
                    {
                        "long": 166.3315,
                        "lat": -50.50551
                    },
                    {
                        "long": 166.3315,
                        "lat": -50.50551
                    },
                    {
                        "long": 166.31914,
                        "lat": -50.51293
                    },
                    {
                        "long": 166.31914,
                        "lat": -50.51293
                    },
                    {
                        "long": 166.30129,
                        "lat": -50.51206
                    },
                    {
                        "long": 166.30129,
                        "lat": -50.51206
                    },
                    {
                        "long": 166.28413,
                        "lat": -50.50507
                    },
                    {
                        "long": 166.28413,
                        "lat": -50.50507
                    },
                    {
                        "long": 166.29374,
                        "lat": -50.53563
                    },
                    {
                        "long": 166.29374,
                        "lat": -50.53563
                    },
                    {
                        "long": 166.29649,
                        "lat": -50.57533
                    },
                    {
                        "long": 166.29649,
                        "lat": -50.57533
                    },
                    {
                        "long": 166.28962,
                        "lat": -50.5919
                    },
                    {
                        "long": 166.28962,
                        "lat": -50.5919
                    },
                    {
                        "long": 166.24155,
                        "lat": -50.65289
                    },
                    {
                        "long": 166.24155,
                        "lat": -50.65289
                    },
                    {
                        "long": 166.22782,
                        "lat": -50.72162
                    },
                    {
                        "long": 166.22782,
                        "lat": -50.72162
                    },
                    {
                        "long": 166.24705,
                        "lat": -50.7807
                    },
                    {
                        "long": 166.24705,
                        "lat": -50.7807
                    },
                    {
                        "long": 166.26215,
                        "lat": -50.84925
                    },
                    {
                        "long": 166.26215,
                        "lat": -50.84925
                    },
                    {
                        "long": 166.2443,
                        "lat": -50.86746
                    },
                    {
                        "long": 166.2443,
                        "lat": -50.86746
                    },
                    {
                        "long": 166.20417,
                        "lat": -50.86486
                    },
                    {
                        "long": 166.20417,
                        "lat": -50.86486
                    },
                    {
                        "long": 166.16504,
                        "lat": -50.85641
                    },
                    {
                        "long": 166.16504,
                        "lat": -50.85641
                    },
                    {
                        "long": 166.12521,
                        "lat": -50.84405
                    },
                    {
                        "long": 166.12521,
                        "lat": -50.84405
                    },
                    {
                        "long": 166.09912,
                        "lat": -50.83148
                    },
                    {
                        "long": 166.09912,
                        "lat": -50.83148
                    },
                    {
                        "long": 166.05929,
                        "lat": -50.83646
                    },
                    {
                        "long": 166.05929,
                        "lat": -50.83646
                    },
                    {
                        "long": 166.10186,
                        "lat": -50.85207
                    },
                    {
                        "long": 166.10186,
                        "lat": -50.85207
                    },
                    {
                        "long": 166.12349,
                        "lat": -50.85489
                    },
                    {
                        "long": 166.12349,
                        "lat": -50.85489
                    },
                    {
                        "long": 166.14444,
                        "lat": -50.85771
                    },
                    {
                        "long": 166.14444,
                        "lat": -50.85771
                    },
                    {
                        "long": 166.16366,
                        "lat": -50.86312
                    },
                    {
                        "long": 166.16366,
                        "lat": -50.86312
                    },
                    {
                        "long": 166.18564,
                        "lat": -50.86832
                    },
                    {
                        "long": 166.18564,
                        "lat": -50.86832
                    },
                    {
                        "long": 166.20967,
                        "lat": -50.87937
                    },
                    {
                        "long": 166.20967,
                        "lat": -50.87937
                    },
                    {
                        "long": 158.95745,
                        "lat": -54.50179
                    },
                    {
                        "long": 158.95745,
                        "lat": -54.50179
                    },
                    {
                        "long": 158.94921,
                        "lat": -54.51854
                    },
                    {
                        "long": 158.94921,
                        "lat": -54.51854
                    },
                    {
                        "long": 158.95058,
                        "lat": -54.54324
                    },
                    {
                        "long": 158.95058,
                        "lat": -54.54324
                    },
                    {
                        "long": 158.94234,
                        "lat": -54.56474
                    },
                    {
                        "long": 158.94234,
                        "lat": -54.56474
                    },
                    {
                        "long": 158.93547,
                        "lat": -54.58385
                    },
                    {
                        "long": 158.93547,
                        "lat": -54.58385
                    },
                    {
                        "long": 158.92724,
                        "lat": -54.60692
                    },
                    {
                        "long": 158.92724,
                        "lat": -54.60692
                    },
                    {
                        "long": 158.92312,
                        "lat": -54.62918
                    },
                    {
                        "long": 158.92312,
                        "lat": -54.62918
                    },
                    {
                        "long": 158.9135,
                        "lat": -54.65303
                    },
                    {
                        "long": 158.9135,
                        "lat": -54.65303
                    },
                    {
                        "long": 158.90252,
                        "lat": -54.6713
                    },
                    {
                        "long": 158.90252,
                        "lat": -54.6713
                    },
                    {
                        "long": 158.88741,
                        "lat": -54.68717
                    },
                    {
                        "long": 158.88741,
                        "lat": -54.68717
                    },
                    {
                        "long": 158.8778,
                        "lat": -54.70781
                    },
                    {
                        "long": 158.8778,
                        "lat": -54.70781
                    },
                    {
                        "long": 170.97371,
                        "lat": -71.85579
                    },
                    {
                        "long": 170.97371,
                        "lat": -71.85579
                    },
                    {
                        "long": 170.9847,
                        "lat": -71.89424
                    },
                    {
                        "long": 170.9847,
                        "lat": -71.89424
                    },
                    {
                        "long": 170.93251,
                        "lat": -71.93858
                    },
                    {
                        "long": 170.93251,
                        "lat": -71.93858
                    },
                    {
                        "long": 170.61759,
                        "lat": -72.1341
                    },
                    {
                        "long": 170.61759,
                        "lat": -72.1341
                    },
                    {
                        "long": 170.50201,
                        "lat": -72.34461
                    },
                    {
                        "long": 170.50201,
                        "lat": -72.34461
                    },
                    {
                        "long": 170.46905,
                        "lat": -72.58295
                    },
                    {
                        "long": 170.46905,
                        "lat": -72.58295
                    },
                    {
                        "long": 170.29327,
                        "lat": -72.71727
                    },
                    {
                        "long": 170.29327,
                        "lat": -72.71727
                    },
                    {
                        "long": 170.01861,
                        "lat": -72.83438
                    },
                    {
                        "long": 170.01861,
                        "lat": -72.83438
                    },
                    {
                        "long": 169.8648,
                        "lat": -73.07271
                    },
                    {
                        "long": 169.8648,
                        "lat": -73.07271
                    },
                    {
                        "long": 169.4583,
                        "lat": -73.21923
                    },
                    {
                        "long": 169.4583,
                        "lat": -73.21923
                    },
                    {
                        "long": 169.34844,
                        "lat": -73.39594
                    },
                    {
                        "long": 169.34844,
                        "lat": -73.39594
                    },
                    {
                        "long": 168.8211,
                        "lat": -73.62669
                    },
                    {
                        "long": 168.8211,
                        "lat": -73.62669
                    },
                    {
                        "long": 167.89825,
                        "lat": -73.88483
                    },
                    {
                        "long": 167.89825,
                        "lat": -73.88483
                    },
                    {
                        "long": 167.10723,
                        "lat": -74.06076
                    },
                    {
                        "long": 167.10723,
                        "lat": -74.06076
                    },
                    {
                        "long": 166.27227,
                        "lat": -74.29441
                    },
                    {
                        "long": 166.27227,
                        "lat": -74.29441
                    },
                    {
                        "long": 165.87676,
                        "lat": -74.44242
                    },
                    {
                        "long": 165.87676,
                        "lat": -74.44242
                    },
                    {
                        "long": 165.81084,
                        "lat": -74.68802
                    },
                    {
                        "long": 165.81084,
                        "lat": -74.68802
                    },
                    {
                        "long": 166.16241,
                        "lat": -74.86113
                    },
                    {
                        "long": 166.16241,
                        "lat": -74.86113
                    },
                    {
                        "long": 167.10723,
                        "lat": -75.03233
                    },
                    {
                        "long": 167.10723,
                        "lat": -75.03233
                    },
                    {
                        "long": 166.24718,
                        "lat": -75.58768
                    },
                    {
                        "long": 166.24718,
                        "lat": -75.58768
                    },
                    {
                        "long": 165.13756,
                        "lat": -75.74543
                    },
                    {
                        "long": 165.13756,
                        "lat": -75.74543
                    },
                    {
                        "long": 164.6212,
                        "lat": -75.82636
                    },
                    {
                        "long": 164.6212,
                        "lat": -75.82636
                    },
                    {
                        "long": 165.81016,
                        "lat": -77.47058
                    },
                    {
                        "long": 165.81016,
                        "lat": -77.47058
                    },
                    {
                        "long": 166.20566,
                        "lat": -75.91461
                    },
                    {
                        "long": 166.20566,
                        "lat": -75.91461
                    },
                    {
                        "long": 166.9206,
                        "lat": -75.58674
                    },
                    {
                        "long": 166.9206,
                        "lat": -75.58674
                    },
                    {
                        "long": 167.73359,
                        "lat": -75.06921
                    },
                    {
                        "long": 167.73359,
                        "lat": -75.06921
                    },
                    {
                        "long": 167.07441,
                        "lat": -74.70836
                    },
                    {
                        "long": 167.07441,
                        "lat": -74.70836
                    },
                    {
                        "long": 167.25019,
                        "lat": -74.31525
                    },
                    {
                        "long": 167.25019,
                        "lat": -74.31525
                    },
                    {
                        "long": 168.48066,
                        "lat": -73.97914
                    },
                    {
                        "long": 168.48066,
                        "lat": -73.97914
                    },
                    {
                        "long": 169.29365,
                        "lat": -73.56157
                    },
                    {
                        "long": 169.29365,
                        "lat": -73.56157
                    },
                    {
                        "long": 169.68915,
                        "lat": -73.2478
                    },
                    {
                        "long": 169.68915,
                        "lat": -73.2478
                    },
                    {
                        "long": 170.34833,
                        "lat": -73.02471
                    },
                    {
                        "long": 170.34833,
                        "lat": -73.02471
                    },
                    {
                        "long": 171.44697,
                        "lat": -71.88583
                    },
                    {
                        "long": 171.44697,
                        "lat": -71.88583
                    },
                    {
                        "long": 169.2463,
                        "lat": -52.57545
                    },
                    {
                        "long": 169.2463,
                        "lat": -52.57545
                    },
                    {
                        "long": 169.23772,
                        "lat": -52.5694
                    },
                    {
                        "long": 169.23772,
                        "lat": -52.5694
                    },
                    {
                        "long": 169.22433,
                        "lat": -52.5646
                    },
                    {
                        "long": 169.22433,
                        "lat": -52.5646
                    },
                    {
                        "long": 169.21128,
                        "lat": -52.55855
                    },
                    {
                        "long": 169.21128,
                        "lat": -52.55855
                    },
                    {
                        "long": 169.19343,
                        "lat": -52.555
                    },
                    {
                        "long": 169.19343,
                        "lat": -52.555
                    },
                    {
                        "long": 169.17764,
                        "lat": -52.55103
                    },
                    {
                        "long": 169.17764,
                        "lat": -52.55103
                    },
                    {
                        "long": 169.20098,
                        "lat": -52.54916
                    },
                    {
                        "long": 169.20098,
                        "lat": -52.54916
                    },
                    {
                        "long": 169.21815,
                        "lat": -52.55333
                    },
                    {
                        "long": 169.21815,
                        "lat": -52.55333
                    },
                    {
                        "long": 169.22914,
                        "lat": -52.56105
                    },
                    {
                        "long": 169.22914,
                        "lat": -52.56105
                    },
                    {
                        "long": 169.24115,
                        "lat": -52.56544
                    },
                    {
                        "long": 169.24115,
                        "lat": -52.56544
                    },
                    {
                        "long": 169.26038,
                        "lat": -52.56648
                    },
                    {
                        "long": 169.26038,
                        "lat": -52.56648
                    },
                    {
                        "long": 169.26896,
                        "lat": -52.56064
                    },
                    {
                        "long": 169.26896,
                        "lat": -52.56064
                    },
                    {
                        "long": 169.27205,
                        "lat": -52.55041
                    },
                    {
                        "long": 169.27205,
                        "lat": -52.55041
                    },
                    {
                        "long": 169.26898,
                        "lat": -52.54765
                    },
                    {
                        "long": 169.26898,
                        "lat": -52.54765
                    },
                    {
                        "long": 169.26177,
                        "lat": -52.54629
                    },
                    {
                        "long": 169.26177,
                        "lat": -52.54629
                    },
                    {
                        "long": 169.25714,
                        "lat": -52.54514
                    },
                    {
                        "long": 169.25714,
                        "lat": -52.54514
                    },
                    {
                        "long": 169.24801,
                        "lat": -52.53813
                    },
                    {
                        "long": 169.24801,
                        "lat": -52.53813
                    },
                    {
                        "long": 169.25213,
                        "lat": -52.52497
                    },
                    {
                        "long": 169.25213,
                        "lat": -52.52497
                    },
                    {
                        "long": 169.2511,
                        "lat": -52.50868
                    },
                    {
                        "long": 169.2511,
                        "lat": -52.50868
                    },
                    {
                        "long": 169.24698,
                        "lat": -52.49425
                    },
                    {
                        "long": 169.24698,
                        "lat": -52.49425
                    },
                    {
                        "long": 169.23702,
                        "lat": -52.46582
                    },
                    {
                        "long": 169.23702,
                        "lat": -52.46582
                    },
                    {
                        "long": 168.27372,
                        "lat": -47.10089
                    }
                ],
                "markers": [],
                "gpx_file": "https://heritage-expeditions.com/media/gpx_routes/HA_Ross_Sea_22.gpx"
            },
            "cabins": [
                {
                    "id": 22523,
                    "name": "Main Deck Triple",
                    "description": "Main Deck Triple Cabins on Deck 3 are a spacious 22m2 and feature two porthole windows, two single beds and one Pullman bed which folds down from the wall, comfortable lounge, writing desk, private en-suite with shower, ample storage and a flat screen entertainment system.",
                    "deck_level": "Deck 3",
                    "image": "https://heritage-expeditions.com/media/uploads/heritage_adventurer/main_deck_triple_edited_s.bradley.jpg",
                    "inclusions": "",
                    "exclusions": "",
                    "price": {
                        "amount": "33075.00",
                        "currency": "USD",
                        "discounted_amount": "33075.00"
                    },
                    "prices": [
                        {
                            "amount": "49365.00",
                            "currency": "AUD",
                            "discounted_amount": "49365.00"
                        },
                        {
                            "amount": "33075.00",
                            "currency": "USD",
                            "discounted_amount": "33075.00"
                        },
                        {
                            "amount": "25445.00",
                            "currency": "GBP",
                            "discounted_amount": "25445.00"
                        },
                        {
                            "amount": "53780.00",
                            "currency": "NZD",
                            "discounted_amount": "53780.00"
                        },
                        {
                            "amount": "31680.00",
                            "currency": "EUR",
                            "discounted_amount": "31680.00"
                        }
                    ],
                    "availability": "Available",
                    "specials": [],
                    "has_special": false
                },
                {
                    "id": 22519,
                    "name": "Superior Triple",
                    "description": "Superior Triple Cabins on Deck 5 are a spacious 22m2 and feature large panoramic windows, two single beds and one Pullman bed which folds down from the wall, comfortable lounge, writing desk, private en-suite with shower, ample storage and a flat screen entertainment system.",
                    "deck_level": "Deck 5",
                    "image": "https://heritage-expeditions.com/media/uploads/heritage_adventurer/superior_triple_dana_brown.jpg",
                    "inclusions": "",
                    "exclusions": "",
                    "price": {
                        "amount": "34285.00",
                        "currency": "USD",
                        "discounted_amount": "34285.00"
                    },
                    "prices": [
                        {
                            "amount": "51175.00",
                            "currency": "AUD",
                            "discounted_amount": "51175.00"
                        },
                        {
                            "amount": "34285.00",
                            "currency": "USD",
                            "discounted_amount": "34285.00"
                        },
                        {
                            "amount": "26375.00",
                            "currency": "GBP",
                            "discounted_amount": "26375.00"
                        },
                        {
                            "amount": "55750.00",
                            "currency": "NZD",
                            "discounted_amount": "55750.00"
                        },
                        {
                            "amount": "32840.00",
                            "currency": "EUR",
                            "discounted_amount": "32840.00"
                        }
                    ],
                    "availability": "Available",
                    "specials": [],
                    "has_special": false
                },
                {
                    "id": 22520,
                    "name": "Deck 4 Superior",
                    "description": "Superior Cabins on Deck 4 are a spacious 22m2 and feature large panoramic windows, king or two single beds, comfortable lounge, writing desk, private en-suite with shower, ample storage and a flat screen entertainment system.",
                    "deck_level": "Deck 4",
                    "image": "https://heritage-expeditions.com/media/uploads/heritage_adventurer/deck_4_superior_dana_brown_edited.jpg",
                    "inclusions": "",
                    "exclusions": "",
                    "price": {
                        "amount": "36515.00",
                        "currency": "USD",
                        "discounted_amount": "36515.00"
                    },
                    "prices": [
                        {
                            "amount": "54500.00",
                            "currency": "AUD",
                            "discounted_amount": "54500.00"
                        },
                        {
                            "amount": "36515.00",
                            "currency": "USD",
                            "discounted_amount": "36515.00"
                        },
                        {
                            "amount": "28090.00",
                            "currency": "GBP",
                            "discounted_amount": "28090.00"
                        },
                        {
                            "amount": "59375.00",
                            "currency": "NZD",
                            "discounted_amount": "59375.00"
                        },
                        {
                            "amount": "34975.00",
                            "currency": "EUR",
                            "discounted_amount": "34975.00"
                        }
                    ],
                    "availability": "Available",
                    "specials": [],
                    "has_special": false
                },
                {
                    "id": 22518,
                    "name": "Deck 5 Superior",
                    "description": "Superior Cabins on Deck 5 are a spacious 22m2 and feature large panoramic windows, king or two single beds, comfortable lounge, writing desk, private en-suite with shower, ample storage and a flat screen entertainment system.",
                    "deck_level": "Deck 5",
                    "image": "https://heritage-expeditions.com/media/uploads/heritage_adventurer/deck_5_superior_dana_brown.jpg",
                    "inclusions": "",
                    "exclusions": "",
                    "price": {
                        "amount": "37675.00",
                        "currency": "USD",
                        "discounted_amount": "37675.00"
                    },
                    "prices": [
                        {
                            "amount": "56230.00",
                            "currency": "AUD",
                            "discounted_amount": "56230.00"
                        },
                        {
                            "amount": "37675.00",
                            "currency": "USD",
                            "discounted_amount": "37675.00"
                        },
                        {
                            "amount": "28990.00",
                            "currency": "GBP",
                            "discounted_amount": "28990.00"
                        },
                        {
                            "amount": "61260.00",
                            "currency": "NZD",
                            "discounted_amount": "61260.00"
                        },
                        {
                            "amount": "36085.00",
                            "currency": "EUR",
                            "discounted_amount": "36085.00"
                        }
                    ],
                    "availability": "Available",
                    "specials": [],
                    "has_special": false
                },
                {
                    "id": 22521,
                    "name": "Main Deck Single",
                    "description": "Main Deck Single Cabins on Deck 3 are a spacious 22m2 and feature two porthole windows, king bed, comfortable lounge, writing desk, private en-suite with shower, ample storage and a flat screen entertainment system.",
                    "deck_level": "Deck 3",
                    "image": "https://heritage-expeditions.com/media/uploads/heritage_adventurer/main_deck_dana_brown.jpg",
                    "inclusions": "",
                    "exclusions": "",
                    "price": {
                        "amount": "44890.00",
                        "currency": "USD",
                        "discounted_amount": "44890.00"
                    },
                    "prices": [
                        {
                            "amount": "67000.00",
                            "currency": "AUD",
                            "discounted_amount": "67000.00"
                        },
                        {
                            "amount": "44890.00",
                            "currency": "USD",
                            "discounted_amount": "44890.00"
                        },
                        {
                            "amount": "34535.00",
                            "currency": "GBP",
                            "discounted_amount": "34535.00"
                        },
                        {
                            "amount": "72995.00",
                            "currency": "NZD",
                            "discounted_amount": "72995.00"
                        },
                        {
                            "amount": "42995.00",
                            "currency": "EUR",
                            "discounted_amount": "42995.00"
                        }
                    ],
                    "availability": "Available",
                    "specials": [],
                    "has_special": false
                },
                {
                    "id": 22522,
                    "name": "Worsley Suite",
                    "description": "Located on Deck 6, Worsley Suites are a spacious 22m2 and feature large panoramic windows, king or two single beds, comfortable chaise-style lounge suite, writing desk, private en-suite with shower, ample storage and a flat screen entertainment system. Receive complimentary in-room dining, minibar replenished daily, Heritage Expeditions keep cup, notebook and pen.",
                    "deck_level": "Deck 6",
                    "image": "https://heritage-expeditions.com/media/uploads/heritage_adventurer/worsley_suite_1_dana_brown.jpg",
                    "inclusions": "",
                    "exclusions": "",
                    "price": {
                        "amount": "45415.00",
                        "currency": "USD",
                        "discounted_amount": "38776.00"
                    },
                    "prices": [
                        {
                            "amount": "67785.00",
                            "currency": "AUD",
                            "discounted_amount": "57879.75"
                        },
                        {
                            "amount": "45415.00",
                            "currency": "USD",
                            "discounted_amount": "38776.00"
                        },
                        {
                            "amount": "34935.00",
                            "currency": "GBP",
                            "discounted_amount": "29829.75"
                        },
                        {
                            "amount": "73845.00",
                            "currency": "NZD",
                            "discounted_amount": "63053.25"
                        },
                        {
                            "amount": "43495.00",
                            "currency": "EUR",
                            "discounted_amount": "37137.25"
                        }
                    ],
                    "availability": "Available",
                    "specials": [
                        {
                            "id": 67,
                            "title": "Save 15%",
                            "description": "<p>Book before 29 August 2025 and <strong>SAVE</strong> <strong>20% </strong>on Heritage Suites and <strong>15%</strong> on Worsley Suites<strong><br /></strong></p>\r\n<p><em>T&amp;C's apply, new bookings only made on In the Wake of Scott &amp; Shackleton departing January and February 2026, excludes landing fees and optional extras, cannot be used in conjunction with any other offer.</em></p>",
                            "end_date": "2025-08-29"
                        }
                    ],
                    "has_special": true
                },
                {
                    "id": 22517,
                    "name": "Superior Single",
                    "description": "Superior Single Cabins on Deck 5 are a spacious 22m2 and feature large panoramic windows, king bed, comfortable lounge, writing desk, private en-suite with shower, ample storage and a flat screen entertainment system.",
                    "deck_level": "Deck 5",
                    "image": "https://heritage-expeditions.com/media/uploads/heritage_adventurer/superior_single_s.bradley%2Ckimberley_edited.png",
                    "inclusions": "",
                    "exclusions": "",
                    "price": {
                        "amount": "46195.00",
                        "currency": "USD",
                        "discounted_amount": "46195.00"
                    },
                    "prices": [
                        {
                            "amount": "68950.00",
                            "currency": "AUD",
                            "discounted_amount": "68950.00"
                        },
                        {
                            "amount": "46195.00",
                            "currency": "USD",
                            "discounted_amount": "46195.00"
                        },
                        {
                            "amount": "35535.00",
                            "currency": "GBP",
                            "discounted_amount": "35535.00"
                        },
                        {
                            "amount": "75115.00",
                            "currency": "NZD",
                            "discounted_amount": "75115.00"
                        },
                        {
                            "amount": "44245.00",
                            "currency": "EUR",
                            "discounted_amount": "44245.00"
                        }
                    ],
                    "availability": "Waitlisted",
                    "specials": [],
                    "has_special": false
                },
                {
                    "id": 22516,
                    "name": "Heritage Suite",
                    "description": "Located on Deck 6, Heritage Suites are an expansive 44m2 and feature large double panoramic windows, king bed, large living area with a sofa, coffee table and chairs and grand marble bathroom with a double basin, bathtub and shower, large writing desk, floor to ceiling cabinetry for storage and a flat screen entertainment system. Receive complimentary in-room dining, minibar replenished daily, free laundry, US$100.00 per person SPA credit, Heritage Expeditions keep cup, notebook and pen.",
                    "deck_level": "Deck 6",
                    "image": "https://heritage-expeditions.com/media/uploads/heritage_adventurer/heritage_suite_3_dana_brown.jpg",
                    "inclusions": "",
                    "exclusions": "",
                    "price": {
                        "amount": "66000.00",
                        "currency": "USD",
                        "discounted_amount": "53031.00"
                    },
                    "prices": [
                        {
                            "amount": "99000.00",
                            "currency": "AUD",
                            "discounted_amount": "79550.00"
                        },
                        {
                            "amount": "66000.00",
                            "currency": "USD",
                            "discounted_amount": "53031.00"
                        },
                        {
                            "amount": "51000.00",
                            "currency": "GBP",
                            "discounted_amount": "40980.00"
                        },
                        {
                            "amount": "107000.00",
                            "currency": "NZD",
                            "discounted_amount": "85980.00"
                        },
                        {
                            "amount": "63000.00",
                            "currency": "EUR",
                            "discounted_amount": "50622.00"
                        }
                    ],
                    "availability": "Available",
                    "specials": [
                        {
                            "id": 25,
                            "title": "Save up to 20%",
                            "description": "<p>Book before 29 August 2025 and <strong>SAVE</strong> <strong>20% </strong>on Heritage Suites and <strong>SAVE</strong> <strong>15%</strong> on Worsley Suites*<strong><br /></strong></p>\r\n<p><em>T&amp;C's apply, new bookings only made on In the Wake of Scott &amp; Shackleton departing January and February 2026 &amp; 2027, excludes landing fees and optional extras, cannot be used in conjunction with any other offer.</em></p>\r\n<p>&nbsp;</p>",
                            "end_date": "2025-08-29"
                        }
                    ],
                    "has_special": true
                }
            ],
            "itinerary": [
                {
                    "day": "Day 1",
                    "label": "Queenstown",
                    "body": "Arrive at Queenstown, New Zealand’s world famous alpine resort town. Guests should make their way to the designated hotel where we will spend the first night of the expedition. This evening there will be an informal get-together at the hotel for dinner; an excellent opportunity to meet fellow adventurers on your voyage and some of our expedition team."
                },
                {
                    "day": "Day 2",
                    "label": "Port of Bluff",
                    "body": "Today we enjoy breakfast in the hotel restaurant and have the morning free to explore Queenstown before returning to the hotel for lunch and departing for the Port of Bluff to embark Heritage Adventurer. You will have time to settle into your stateroom or suite and familiarise yourself with the ship. You are invited to join the expedition team in the Observation Lounge and up on the Observation Deck as we set our course to The Snares and our adventure begins."
                },
                {
                    "day": "Day 3",
                    "label": "The Snares - North East Island",
                    "body": "The closest Subantarctic Islands to New Zealand, they were appropriately called The Snares because they were probably considered a hazard by their discoverer Lieutenant Broughton in 1795. Comprising of two main islands and a smattering of rocky islets, they are uninhabited and highly protected.\r\n\r\nNorth East Island is the largest of The Snares and it is claimed that this one island is home to more nesting seabirds than all of the British Isles together. We will arrive early in the morning and cruise along the sheltered eastern side of the rugged coastline by Zodiac if weather and sea conditions are suitable (landings are not permitted). In the sheltered bays, we should see the endemic Snares Crested Penguins, Snares Island Tomtit and Fernbirds. Cape Pigeons and Antarctic Terns are also present in good numbers. There are hundreds of thousands of Sooty Shearwaters nesting on The Snares; the actual number is much debated. Around Christmas time each year the Buller’s Albatross return here to nest."
                },
                {
                    "day": "Day 4",
                    "label": "Auckland Islands - Enderby Island",
                    "body": "The Auckland Islands group was formed by two volcanoes which erupted some 10-25 million years ago. They have subsequently been eroded and dissected by glaciation creating the archipelago as we know it today. Enderby Island is one of the most beautiful islands in this group and is named for the distinguished shipping family. This northern most island in the archipelago is an outstanding wildlife and birding location and is relatively easy to land on and walk around.\r\n\r\nThe island was cleared of all introduced pests in 1994 and both birds and the vegetation, especially the herbaceous plants, are recovering both in numbers and diversity. Our plan is to land at Sandy Bay, one of three breeding areas in the Auckland Islands for the Hooker’s or New Zealand Sea Lion, a rare member of the seal family. Beachmaster bulls gather on the beach defending their harems and mating with the cows shortly after they have given birth to a single pup. \r\n\r\nOn shore there will be several options, some longer walks, some shorter walks and time to enjoy the wildlife. The walking is relatively easy, a board walk traverses the island to the dramatic western cliffs from there we follow the coast on the circumnavigation of the island. Birds that we are likely to encounter include the following species: Southern Royal Albatross, Northern Giant Petrel, Auckland Island Shag, Auckland Island Flightless Teal, Auckland Island Banded Dotterel, Auckland Island Tomtit, Bellbird, Pipit, Red-crowned Parakeet, Yellow-eyed Penguin and Light-mantled Sooty Albatross. There is also a very good chance of seeing the Subantarctic Snipe."
                },
                {
                    "day": "Day 5",
                    "label": "At Sea",
                    "body": "At sea, learn more about the biology and history of the Subantarctic Islands and the Southern Ocean through a series of lectures and presentations. We will be at sea all day, so it is another opportunity to spot pelagic species including (but not limited to) the Wandering Albatross, Royal Albatross, Shy and White-capped Albatross, Light-mantled Sooty Albatross, Grey-headed Albatross and Black-browed Albatross, White-chinned Petrel, Mottled Petrel, White-headed Petrel, Cape Petrel, diving-petrel, Grey-backed and Black-bellied Storm-petrels. This is potentially some of the best pelagic ‘birding’ on the expedition."
                },
                {
                    "day": "Days 6 to 7",
                    "label": "Maquarie Island",
                    "body": "Australia’s prized Subantarctic possession, it supports one of the highest concentrations of wildlife in the Southern Ocean. Millions of penguins of four different species – King, Rockhopper, Gentoo and the endemic Royal – breed here. We plan to spend our time divided between the two approved landing sites, Sandy Bay and Buckles Bay as well as a Zodiac cruise at Lusitania Bay if weather conditions permit.\r\nAt Sandy Bay a Royal Penguin rookery teems with feisty little birds trotting back and forth, golden head plumes bobbing as they march to and from the shore. All three million of the world’s Royal Penguins breed on Macquarie Island. There is also a substantial King Penguin colony. Some of the best observations will be had by quietly standing and letting the birds come to you. They are both unafraid and inquisitive – the combination is unique. \r\n\r\nAt Buckles Bay we hope to have a guided tour of the Australian Antarctic Division Base which was established in the late 1940s and has been manned continuously since then. Large groups of Southern Elephant Seals slumber on the beaches and in the tussock at both of our landing sites. These giant, blubbery creatures will barely acknowledge our presence, lying in groups of intertwined bodies, undergoing their annual moult. Younger bulls spar in the shallow water, preparing for their mature years when they will look after their own harems.\r\n\r\nThe King Penguin rookery at Lusitania Bay is noisy and spectacular. A welcoming committee will likely porpoise around our Zodiacs as a quarter of a million King Penguins stand at attention on shore. Rusting digesters in the centre are grim reminders of a time when scores of penguins were slaughtered for their oil. Now their offspring have reclaimed this territory. \r\n\r\nService, who administer the island, embarked on a very ambitious 7-year eradication programme resulting in the island earning pest-free status in 2014. Both the birds and plants have responded and it is amazing to witness the regeneration and the increase in the number of birds. It is an amazing island, in addition to the penguins and elephant seals, there are three species of fur seals to be found there and four species of albatross, Wandering, Black-browed, Grey-headed and Light-mantled Sooty."
                },
                {
                    "day": "Day 8 to 10",
                    "label": "At Sea",
                    "body": "Soaring albatross and petrels circle the vessel as we steam ever southward through the Southern Ocean. Lectures now concentrate on Antarctica and the Ross Sea region. We will pay attention to water temperatures so that we know when we cross the Antarctic Convergence into the cold but extremely productive Antarctic waters. Drifting icebergs carry vivid colours and come in extraordinary shapes. Each is a unique, natural sculpture. The captain will manoeuvre the ship in close for your first ice photograph and we will celebrate as we pass the Antarctic Circle and into Antarctica’s realm of 24-hour daylight! Relax in the ship’s bar and catch up with some reading in the library. If you have brought your laptop with you there will be time to download and edit photos while they are fresh in  your mind."
                },
                {
                    "day": "Days 11 to 22",
                    "label": "Antarctica’s Ross Sea Region",
                    "body": "During our time in the Ross Sea region, we will visit the highlights of Antarctica’s most historic region. Due to the unpredictable nature of ice and weather conditions, a day-by-day itinerary is not possible. The Captain and Expedition Leader will assess daily conditions and take advantage of every opportunity to make landings and explore in the Zodiacs. Our programme emphasises wildlife viewing, key scientific bases and historic sites, as well as the spectacular scenery of the coastal terrain, the glaciers and icebergs of the Ross Sea. Whilst specific landings cannot be guaranteed, we hope to visit the following:\r\n\r\nCape Adare\r\nCape Adare’s bold headland and the Downshire Cliffs greet us as we approach Cape Adare – ice conditions permitting – at the tip of the Ross Sea, the site of the largest Adelie Penguin rookery in Antarctica. Blanketing the large, flat spit which forms the cape is the huge rookery which now, at the height of summer, numbers over one million birds – an absolutely staggering sight. You will never forget your first experiences in a ceaselessly active and noisy ‘penguin city’, where the dapper inhabitants show no fear of their strange visitors. Our naturalists will point out various aspects of their lifestyle and, by standing quietly, one may observe the often comical behaviour of the penguins, courtship displays, feeding ever-hungry chicks, territorial disputes and the pilfering of nest material. Surrounded by a sea of penguins we will find Borchgrevink’s Hut, the oldest in Antarctica, an overwintering shelter for the first expedition to the continent in 1899. It is a fascinating relic of the ‘Heroic Age’ of Antarctic exploration and we are able to inspect the interior, which still contains artefacts of the early explorers. One thousand feet up in the hills behind Cape Adare is the oldest grave in Antarctica, that of 22-year-old Nicolai Hansen, a member of Borchgrevink’s expedition.\r\n\r\nCape Hallett\r\nThe enormous Admiralty Range heralds our arrival at Cape Hallett. The scenery here is wild and spectacular; mountains rise up towering out of the sea to over 4,000-metres high and giant glaciers course down from the interior to the water’s edge. We land next to the site of the abandoned American/New Zealand base, home to large numbers of Adelie Penguins and Weddell Seals.\r\n\r\nFranklin Island\r\nThis rugged island, deep in the Ross Sea, is home to a large Adelie Penguin colony and other nesting seabirds. We will attempt a Zodiac landing near the rookery as well as exploring the coastline. If a landing is achieved and weather conditions are suitable there will be an opportunity to explore this remarkable island.\r\n\r\nPossession Islands\r\nThese small, rugged and rarely visited islands lie off the shore of Cape Hallett. An Adelie Penguin rookery, numbering tens of thousands of birds, blankets Foyn Island. Observe their busy and sometimes humorous activities, with the Admiralty Mountains forming a superb backdrop across the water.\r\n\r\nRoss Ice Shelf\r\nThe largest ice shelf in Antarctica, the Ross Ice Shelf is also the world’s largest body of floating ice. A natural ice barrier, at times it creates hazardous weather conditions, with sheets of snow blown at gale force by the katabatic winds coming off the polar ice cap. Just 1,287 kilometres from the South Pole, this daunting spectacle prevented early Antarctic explorers from venturing further south. From the Ross Ice Shelf we cruise eastward along the shelf front, with its spectacular 30-metre high ice cliffs, which sometimes calve tabular icebergs.\r\n\r\nRoss Island – Mount Erebus/Cape Bird/Shackleton’s Hut/Scott’s Hut\r\nAt the base of the Ross Sea we arrive at Ross Island, dominated by the 3,794-metre high volcano, Mt Erebus. The New Zealand Antarctica programme maintains a field station at Cape Bird, where scientists study many aspects of the region’s natural history, including the large Adelie Penguin colony. At Cape Royds we visit Sir Ernest Shackleton’s hut, built during the Nimrod polar expedition of 1907-1909. Lectures explain many facets of Shackleton’s amazing expeditions. He was possibly one of the greatest, and certainly one of the most heroic of the Antarctic explorers. Though the legendary explorers are long gone, the area around the hut is far from deserted, having been reclaimed by the original inhabitants of the area – thousands of Adelie Penguins in the world’s southernmost penguin rookery.\r\n\r\nAlso found on Ross Island is Cape Evans, the historic site of Captain Scott’s second hut, erected in 1911 and beautifully preserved by the Antarctic Heritage Trust. It stands as testimony to the rigours faced by pioneering explorers. Inside the hut we will witness the living conditions almost exactly as they were when Scott, Wilson and Ponting occupied these quarters. Behind the hut, Mt Erebus looms above with its plume of white smoke spiralling up from the still-active inferno in its bowels.\r\n\r\nMcMurdo and Scott Base \r\n(including Scott’s Discovery Hut) These are always on our wish list but ice, weather and operational requirements for the National Programs icebreaker activities sometimes prevent us from visiting, especially on the January expedition. Our February expedition is generally more successful but not guaranteed.\r\n\r\nTerra Nova Bay\r\nStazione Mario Zucchelli, an Italian summer research station, is an interesting shipping container construction. The friendly scientists and support staff here are always most hospitable and enjoy showing us around their lonely but beautiful home. The Italians conduct many streams of scientific research and also claim to have the best ‘espresso’ in Antarctica! Nearby is the German base, Gondwana Station, which is used occasionally and the South Korean station, Jang Bogo and on Inexpressible Island, is China’s fifth Antarctic base, Qinling Station."
                },
                {
                    "day": "Days 23 to 25",
                    "label": "At Sea",
                    "body": "En route to Campbell Island, take part in a series of lectures designed to prepare you for our visit tomorrow. Pelagic species abound here as they did en route to Macquarie Island earlier in our voyage. Above all, take the time to rest and enjoy shipboard life after the excitement of the Antarctic."
                },
                {
                    "day": "Day 26",
                    "label": "Campbell Island - Perseverance Harbour",
                    "body": "New Zealand’s southernmost Subantarctic territory, the Campbell Island group lies approximately 660-kilometres south of Bluff. We visit Campbell Island, the main island in the group, and spend the day exploring the island on foot from Perseverance Harbour, a long inlet cutting into the undulating landscape. Campbell Island is a truly magnificent place of rugged scenery, unique flora and abundant wildlife. Perseverance Harbour where we drop anchor is an occasional refuge for Southern Right Whales who come here to calve. Here we will find a now abandoned New Zealand meteorological station as well as Campbell Island Shags, penguins, fur seals and rare Hooker’s/New Zealand Sea Lions.\r\n\r\nThe highlight of our visit is a walk to the hilltop breeding sites of Southern Royal Albatross, over six thousand pairs of which breed on Campbell Island. These magnificent birds, close relations to, and the same size as, the Wandering Albatross, have the largest wingspan in the world and their gamming makes them superb photographic subjects."
                },
                {
                    "day": "Day 27",
                    "label": "At Sea",
                    "body": "At sea en route to the Port of Bluff, take the opportunity to relax and reflect on an amazing experience. This is a good opportunity to download and edit any remaining photos while they are fresh in your mind and you have the experience of our expedition team on board for questions. We will recap the highlights of our expedition and enjoy a farewell dinner tonight as we sail to our final port."
                },
                {
                    "day": "Day 28",
                    "label": "Invercargill/Queenstown",
                    "body": "Early this morning we will arrive in the Port of Bluff. After a final breakfast and completing Custom formalities we bid farewell to our fellow voyagers and take a complimentary coach transfer to either Invercargill or Queenstown Airports. In case of unexpected delays due to weather and/or port operations we ask you not to book any onward travel until after midday from Invercargill and after 3pm from Queenstown.\r\n\r\nNote: During our voyage, circumstances may make it necessary or desirable to deviate from the proposed itinerary. This can include poor weather and opportunities for making unplanned excursions. Your Expedition Leader will keep you fully informed. This tour offers a variety of activities and excursions. Your personal interests will determine which of these you wish to join. Please note that some activities and excursions will run at similar times, and it will not be possible to participate in both. Accordingly, refunds for excursions and missed landings are not available. Voyages are planned and scheduled pending final regulatory approval. Landings at the Subantarctic Islands of New Zealand are by permit only as administered by the Government of New Zealand. No landings are permitted at The Snares."
                }
            ],
            "destinations": [
                "Antarctica"
            ],
            "locations": [
                "Auckland Islands",
                "Campbell Island",
                "Macquarie Island",
                "The Ross Sea"
            ],
            "countries": [
                "Antarctica"
            ],
            "gallery": [
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/(c)_heritage_expeditions_antarctica_5_(custom).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/133_20150125_045032_agnes_breniere_(custom).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/(c)_ebell_antarctica4_(custom).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/amundsen/20160217_225705_samuel_blanc_(custom).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/am2k5823_(custom).jpg",
                "https://heritage-expeditions.com/media/uploads/in_the_wake_of_scott_and_shackleton/230124_julia_mishina_zodiac_cruise.jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/(c)_kovsyanikova_antarctica_25_(custom).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/(c)_kovsyanikova__(14).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/1671_15_26_jan_2016_cape_evans_fergus_(1)_(custom).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/019_20150113_100303_samuel_blanc_(custom).jpg",
                "https://heritage-expeditions.com/media/uploads/in_the_wake_of_scott_and_shackleton/230220__richard_young_96603.jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/(c)_tbickford_antarctica__(8).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/p1010983_(custom).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/174_20150127_213256_samuel_blanc_(custom).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/(c)_ebell_antarctica6_(custom).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/amundsen/20160129_100248_samuel_blanc_(custom).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/(c)_kovsyanikova__(13).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/(c)_kovsyanikova_antarctica_22_(custom).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/amundsen/20160121_234121_samuel_blanc_(custom).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/(c)_kovsyanikova__(6).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/amundsen/20160303_170431_samuel_blanc_(custom).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/(c)_kovsyanikova_antarctica_36_(custom).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/214_20150129_120402_agnes_breniere_(custom).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/amundsen/20160226_074843_samuel_blanc_(custom).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/(c)_ebell_antarctica5_(custom).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/(c)_kovsyanikova__(10).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/amundsen/20160118_213309_samuel_blanc_(custom).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/amundsen/20160118_091730_samuel_blanc_(custom).jpg",
                "https://heritage-expeditions.com/media/uploads/in_the_wake_of_scott_and_shackleton/230215_shackltons_hut_richard_young_94044.jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/033_20150114_112051_samuel_blanc_(custom).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/(c)_heritage_expeditions_auckland_islands_1_(custom).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/218_20150129_130644_samuel_blanc_(custom).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/(c)_kovsyanikova_antarctica_34_(custom).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/amundsen/20160224_165601_samuel_blanc_(custom).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/(c)_ebell_antarctica2_(custom).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/(c)_kovsyanikova_antarctica_26_(custom).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/020_20150113_100509_samuel_blanc_(custom).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/(c)_heritage_expeditions_auckland_islands_(custom).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/(c)_tbickford_antarctica__(10).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/(c)_kovsyanikova_antarctica_17_(custom).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/1671_4_15_jan_2016_enderby_fergus_(46)_(custom).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/(c)_tbickford_antarctica__(12).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/(c)_heritage_expeditions_antarctica_6_(custom).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/(c)_kovsyanikova_antarctica_33_(custom).jpg",
                "https://heritage-expeditions.com/media/uploads/february_14%2C_2025stephenbradley-cape_adare-29.jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/(c)_ebell_antarctica7_(custom).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/dscn2392_(custom).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/241_20150205_142234_samuel_blanc_(custom).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/lorna_terra_nova_(custom).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/070_20150118_110141_samuel_blanc_(custom).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/1671_13_24_jan_2016_cape_adare_fergus_(28)_(custom).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/126_20150125_040651_samuel_blanc_(custom).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/1671_4_15_jan_2016_enderby_fergus_(47)_(custom).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/170_20150127_182520_samuel_blanc_(custom).jpg",
                "https://heritage-expeditions.com/media/uploads/in_the_wake_of_scott_and_shackleton/230110_enderby_island_frede_lamo_(116).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/(c)_tbickford_antarctica__(15).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/108_20150124_193024_agnes_breniere_(custom).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/(c)_heritage_expeditions_antarctica_2_(custom).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/(c)_tbickford_antarctica__(16).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/amundsen/20160224_054334-panorama_samuel_blanc_(custom).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/(c)_kovsyanikova_antarctica_14_(custom).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/amundsen/20160221_213554_samuel_blanc_(custom).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/115_20150124_202103_agnes_breniere_(custom).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/amundsen/20160118_184713_samuel_blanc_(custom).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/155_20150127_035329_samuel_blanc_(custom).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/(c)_tbickford_antarctica__(13).jpg",
                "https://heritage-expeditions.com/media/uploads/in_the_wake_of_scott_and_shackleton/230119_m.snedic_at_sea_img_2904.jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/(c)_heritage_expeditions_antarctica_8_(custom).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/(c)_tbickford_antarctica__(3).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/1671_13_24_jan_2016_cape_adare_fergus_(11)_(custom).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/1671_13_24_jan_2016_cape_adare_fergus_(10)_(custom).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/(c)_ebell_antarctica1_(custom).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/(c)_tbickford_antarctica__(4).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/(c)_kovsyanikova__(5).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/(c)_kovsyanikova__(11).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/169_20150127_083825_samuel_blanc_(custom).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/(c)_kovsyanikova_antarctica_30_(custom).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/045_20150114_130147_samuel_blanc_(custom).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/134_20150125_053115_samuel_blanc_(custom).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/p1020948_(custom).jpg",
                "https://heritage-expeditions.com/media/uploads/in_the_wake_of_scott_and_shackleton/230117_m.snedic_passengers_img_2823.jpg",
                "https://heritage-expeditions.com/media/uploads/in_the_wake_of_scott_and_shackleton/20230119_julia_mishina_foyn_island_.jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/(c)_kovsyanikova_antarctica_32_(custom).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/(c)_kovsyanikova_antarctica_15_(custom).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/weddell_seal.jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/(c)_kovsyanikova__(8).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/(c)_kovsyanikova_antarctica_10_(custom).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/(c)_kovsyanikova_antarctica_18_(custom).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/(c)_kovsyanikova_antarctica_20_(custom).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/img_4045_(custom).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/(c)_kovsyanikova_antarctica_28_(custom).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/p1020018_(custom).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/(c)_ebell_antarctica3_(custom).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/(c)_heritage_expeditions_antarctica_1_(custom).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/1671_13_24_jan_2016_cape_adare_fergus_(15)_(custom).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/1671_4_15_jan_2016_enderby_fergus_(26)_(custom).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/240_20150131_232835_samuel_blanc_(custom).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/(c)_kovsyanikova__(12).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/118_20150124_202933_agnes_breniere_(custom).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/(c)_kovsyanikova_antarctica_35_(custom).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/lorna_cape_evans_(custom).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/lorna_enderby_(custom).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/1671_5_16_jan_2016_carnley_%26_musgrave_fergus_(17)_(custom).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/198_20150128_211055_samuel_blanc_(custom).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/(c)_tbickford_antarctica__(14).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/1671_3_14_jan_2016_snares_fergus_(3)_(custom).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/039_20150114_123421_samuel_blanc_(custom).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/1671_4_15_jan_2016_enderby_fergus_(7)_(custom).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/(c)_kovsyanikova_antarctica_11_(custom).jpg",
                "https://heritage-expeditions.com/media/uploads/in_the_wake_of_scott_and_shackleton/2023-01-12-samuel_blanc-macca-kings_ashore.jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/lorna_inexpressible_(2)_(custom).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/(c)_kovsyanikova__(9).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/202_20150128_214029_samuel_blanc_(custom).jpg",
                "https://heritage-expeditions.com/media/uploads/in_the_wake_of_scott_and_shackleton/230126_julia_mishina_adelie_on_ice_2.jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/1671_8_19_jan_2016_macquarie_sandy_bay_fergus_(36)_(custom).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/217_20150129_122631_samuel_blanc_(custom).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/lorna_scott_base__(custom).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/(c)_kovsyanikova__(2).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/123_20150125_031408_agnes_breniere_(custom).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/(c)_kovsyanikova_antarctica_16_(custom).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/(c)_tbickford_antarctica__(6).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/(c)_kovsyanikova_antarctica_24_(custom).jpg",
                "https://heritage-expeditions.com/media/uploads/february_16%2C_2025stephenbradley-scott_base-5(1).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/(c)_tbickford_antarctica.jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/230_20150131_171159_agnes_breniere_(custom).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/244_20150205_150759_samuel_blanc_(custom).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/amundsen/20160226_165340-panorama_samuel_blanc_(custom).jpg",
                "https://heritage-expeditions.com/media/uploads/trip_folders/antarctic_voyages_/ross_sea_/(c)_heritage_expeditions_antarctica_3_(custom).jpg"
            ],
            "meta": {
                "title": "Antarctic & Macquarie Island Voyage | Heritage Expeditions",
                "description": "Explore Antarctica's Ross Sea & the remote Subantarctic Islands on this 28 day expedition cruise from NZ. Wildlife; whales, penguins, seals; history & adventure as featured on Go Further South, Antarctica from above and Conde Nast Traveler's The 25 Best Places to Go in 2025",
                "keywords": "Ross Sea, Antarctic, Go Further South, Ross Ice Shelf, Albatross, Scott Base, McMurdo Station, Adelie Penguin, Penguins, Seals, Macquarie Island, Whales,Conde Nast Traveler",
                "url": "https://heritage-expeditions.com/destinations/antarctica-travel/ross-sea-antarctica-cruise/"
            }
        }
    ],
    "first_page_url": "http://127.0.0.1:8000/api/api/one?page=1&per_page=1",
    "from": 1,
    "last_page": 90,
    "last_page_url": "http://127.0.0.1:8000/api/api/one?page=90&per_page=1",
    "links": [
        {
            "url": null,
            "label": "&laquo; Previous",
            "active": false
        },
        {
            "url": "http://127.0.0.1:8000/api/api/one?page=1&per_page=1",
            "label": "1",
            "active": true
        },
        {
            "url": "http://127.0.0.1:8000/api/api/one?page=2&per_page=1",
            "label": "2",
            "active": false
        },
        {
            "url": "http://127.0.0.1:8000/api/api/one?page=3&per_page=1",
            "label": "3",
            "active": false
        },
        {
            "url": "http://127.0.0.1:8000/api/api/one?page=4&per_page=1",
            "label": "4",
            "active": false
        },
        {
            "url": "http://127.0.0.1:8000/api/api/one?page=5&per_page=1",
            "label": "5",
            "active": false
        },
        {
            "url": "http://127.0.0.1:8000/api/api/one?page=6&per_page=1",
            "label": "6",
            "active": false
        },
        {
            "url": "http://127.0.0.1:8000/api/api/one?page=7&per_page=1",
            "label": "7",
            "active": false
        },
        {
            "url": "http://127.0.0.1:8000/api/api/one?page=8&per_page=1",
            "label": "8",
            "active": false
        },
        {
            "url": "http://127.0.0.1:8000/api/api/one?page=9&per_page=1",
            "label": "9",
            "active": false
        },
        {
            "url": "http://127.0.0.1:8000/api/api/one?page=10&per_page=1",
            "label": "10",
            "active": false
        },
        {
            "url": null,
            "label": "...",
            "active": false
        },
        {
            "url": "http://127.0.0.1:8000/api/api/one?page=89&per_page=1",
            "label": "89",
            "active": false
        },
        {
            "url": "http://127.0.0.1:8000/api/api/one?page=90&per_page=1",
            "label": "90",
            "active": false
        },
        {
            "url": "http://127.0.0.1:8000/api/api/one?page=2&per_page=1",
            "label": "Next &raquo;",
            "active": false
        }
    ],
    "next_page_url": "http://127.0.0.1:8000/api/api/one?page=2&per_page=1",
    "path": "http://127.0.0.1:8000/api/api/one",
    "per_page": 1,
    "prev_page_url": null,
    "to": 1,
    "total": 90
} */
