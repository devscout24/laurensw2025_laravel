<?php
namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $categories = [
        //     [
        //         'name'     => 'Uncategorized',
        //         'image'    => 'default.jpg',
        //         'priority' => 0,
        //         'slug'     => 'active',
        //     ],
        // ];

        // foreach ($categories as $cat) {
        //     Category::updateOrCreate(
        //         ['name' => $cat['name']], // unique field to check
        //         [
        //             'image'    => $cat['image'],
        //             'priority' => $cat['priority'],
        //             'slug'     => $cat['slug'],
        //         ]
        //     );
        // }
    }
}
