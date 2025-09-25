<?php
namespace App\Http\Controllers\Web\backend\tazim;

use App\Http\Controllers\Controller;
use App\Models\HomePageMetaTag;
use App\Models\Language;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HomePageMetaTagController extends Controller
{
    // public function create()
    // {
    //     $data = HomePageMetaTag::whereId(1)->first();
    //     $languages = Language::all();
    //     return view('backend.layout.tazim.homePageMetaTag.create', compact('data', 'languages'));
    // }

    // public function store(Request $request)
    // {
    //     try {
    //         $request->validate([
    //             'title'         => 'required',
    //             'description'   => 'required',
    //             'language_code' => 'required|exists:languages,code',
    //         ]);

    //         $data = HomePageMetaTag::find(1);

    //         if (! $data) {
    //             $data     = new HomePageMetaTag();
    //             $data->id = 1;
    //         }

    //         $data->title         = $request->title;
    //         $data->description   = $request->description;
    //         $data->language_code = $request->language_code;

    //         $data->save();

    //         return redirect()->route('homePageMetaTag.create')->with('success', 'Data Saved/Updated Successfully');

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

        // Fetch existing meta tags for each language
        $metaTags = HomePageMetaTag::get()->keyBy('language_code');

        return view('backend.layout.tazim.homePageMetaTag.create', compact('languages', 'metaTags'));
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
            $data = HomePageMetaTag::firstOrNew(['language_code' => $request->language_code]);

            $data->title         = $request->title;
            $data->description   = $request->description;
            $data->language_code = $request->language_code;

            $data->save();

            return redirect()->route('homePageMetaTag.create')
                ->with('success', 'Data Saved/Updated Successfully');

        } catch (Exception $e) {
            Log::error('Data store/update failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'input' => $request->all(),
            ]);

            return redirect()->back()->with('error', 'Something went wrong while saving the data.')->withInput();
        }
    }

}
