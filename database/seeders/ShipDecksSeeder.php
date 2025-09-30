<?php
namespace Database\Seeders;

use App\Models\ShipDecks;
use Illuminate\Database\Seeder;

class ShipDecksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $decks = [
            [
                'shipview_id' => 1,
                'title'       => 'Sun Deck',
                'image'       => 'decks/sun_deck1.jpg',
            ],
            [
                'shipview_id' => 1,
                'title'       => 'Main Deck',
                'image'       => 'decks/main_deck1.jpg',
            ],
            [
                'shipview_id' => 2,
                'title'       => 'Upper Deck',
                'image'       => 'decks/upper_deck1.jpg',
            ],
        ];

        foreach ($decks as $deck) {
            ShipDecks::firstOrCreate([
                'shipview_id' => $deck['shipview_id'],
                'title'       => $deck['title'],
            ], $deck);
        }
    }
}
