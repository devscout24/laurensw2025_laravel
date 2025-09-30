<?php
namespace App\Http\Controllers\Web\backend\tazim;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\ShipPageMetaTag;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ShipPageMetaTagController extends Controller
{
    // public function create1()
    // {
    //     $data = ShipPageMetaTag::whereId(1)->first();
    //     return view('backend.layout.tazim.shipPageMetaTag.create', compact('data'));
    // }

    // public function store1(Request $request)
    // {
    //     try {
    //         $request->validate([
    //             'title'       => 'required',
    //             'description' => 'required',
    //         ]);

    //         $data = ShipPageMetaTag::find(1);

    //         if (! $data) {
    //             $data     = new ShipPageMetaTag();
    //             $data->id = 1;
    //         }

    //         $data->title       = $request->title;
    //         $data->description = $request->description;

    //         $data->save();

    //         return redirect()->route('shipPageMetaTag.create')->with('success', 'Data Saved/Updated Successfully');

    //     } catch (Exception $e) {
    //         Log::error('Data store/update failed: ' . $e->getMessage(), [
    //             'trace' => $e->getTraceAsString(),
    //             'input' => $request->all(),
    //         ]);

    //         return redirect()->back()->with('error', 'Something went wrong while saving the data.')->withInput();
    //     }
    // }

    public function create()
    {
        $languages = Language::all();
        $metaTags  = ShipPageMetaTag::get()->keyBy('language_code');

        return view('backend.layout.tazim.shipPageMetaTag.create', compact('languages', 'metaTags'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'title'         => 'required',
                'description'   => 'required',
                'language_code' => 'required|exists:languages,code',
            ]);

            // Find existing meta tag for this language
            $data = ShipPageMetaTag::firstOrNew(['language_code' => $request->language_code]);

            $data->title         = $request->title;
            $data->description   = $request->description;
            $data->language_code = $request->language_code;

            $data->save();

            return redirect()->route('shipPageMetaTag.create')
                ->with('success', 'Data Saved/Updated Successfully');

        } catch (Exception $e) {
            Log::error('Data store/update failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'input' => $request->all(),
            ]);

            return redirect()->back()->with('error', 'Something went wrong while saving the data.' . $e->getMessage())->withInput();
        }
    }
}
