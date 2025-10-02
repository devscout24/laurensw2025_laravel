<?php
namespace App\Http\Controllers\API\tazimApi;

use App\Http\Controllers\Controller;
use App\Models\ShipCabins;
use App\Models\ShipView;
use App\Traits\apiresponse;

class ShipViewApiController extends Controller
{
    use apiresponse;

    public function index()
    {
        $data = ShipView::select(
            'id',
            'name',
            'description',
            'build_year',
            'crew_number',
            'max_guests',
            'length',
            'zodiac_boats',
            'capacity',
            'comfort_level',
            'price',
            'image'
        )->get();

        $data->map(function ($item) {
            $item->image = asset($item->image);
            return $item;
        });

        return $this->success($data, 'Success', 200);
    }

    public function allShipData()
    {
        // Eager load cabins, amenities, and decks
        $ships = ShipView::with(['cabins', 'amenities', 'decks'])
            ->select(
                'id',
                'name',
                'description',
                'build_year',
                'crew_number',
                'max_guests',
                'length',
                'zodiac_boats',
                'capacity',
                'comfort_level',
                'price',
                'image'
            )
            ->get();

        // Map to format image URLs and nested relations
        $ships->map(function ($ship) {
            $ship->image = $ship->image ? asset($ship->image) : null;

            // Cabins
            if ($ship->cabins) {
                $ship->cabins->map(function ($cabin) {
                    $cabin->image           = $cabin->image ? asset($cabin->image) : null;
                    $cabin->cabin_type_name = ShipCabins::CABIN_TYPES[$cabin->cabin_type] ?? $cabin->cabin_type;
                    return $cabin;
                });
            }

            // Amenities
            if ($ship->amenities) {
                $ship->amenities->map(function ($amenity) {
                    $amenity->image = $amenity->image ? asset($amenity->image) : null;
                    return $amenity;
                });
            }

            // Decks
            if ($ship->decks) {
                $ship->decks->map(function ($deck) {
                    $deck->image = $deck->image ? asset($deck->image) : null;
                    return $deck;
                });
            }

            return $ship;
        });

        return $this->success($ships, 'Success', 200);
    }

    public function individualShipData($id)
    {
        $ship = ShipView::with(['cabins', 'amenities', 'decks'])
            ->select(
                'id',
                'name',
                'description',
                'build_year',
                'crew_number',
                'max_guests',
                'length',
                'zodiac_boats',
                'capacity',
                'comfort_level',
                'price',
                'image'
            )
            ->find($id);

        if (! $ship) {
            return $this->error('Ship not found', 404);
        }

        // Format image
        $ship->image = $ship->image ? asset($ship->image) : null;

        // Format cabins
        if ($ship->cabins) {
            $ship->cabins->map(function ($cabin) {
                $cabin->image           = $cabin->image ? asset($cabin->image) : null;
                $cabin->cabin_type_name = ShipCabins::CABIN_TYPES[$cabin->cabin_type] ?? $cabin->cabin_type;
                return $cabin;
            });
        }

        // Format amenities
        if ($ship->amenities) {
            $ship->amenities->map(function ($amenity) {
                $amenity->image = $amenity->image ? asset($amenity->image) : null;
                return $amenity;
            });
        }

        // Format decks
        if ($ship->decks) {
            $ship->decks->map(function ($deck) {
                $deck->image = $deck->image ? asset($deck->image) : null;
                return $deck;
            });
        }

        return $this->success($ship, 'Success', 200);
    }

}
