<?php
namespace App\Http\Controllers\Web\backend\tazim;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\NaturePageMetaTag;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class NaturePageMetaTagController extends Controller
{
    // public function create()
    // {
    //     $data = NaturePageMetaTag::whereId(1)->first();
    //     return view('backend.layout.tazim.naturePageMetaTag.create', compact('data'));
    // }

    // public function store(Request $request)
    // {
    //     try {
    //         $request->validate([
    //             'title'       => 'required',
    //             'description' => 'required',
    //         ]);

    //         $data = NaturePageMetaTag::find(1);

    //         if (! $data) {
    //             $data     = new NaturePageMetaTag();
    //             $data->id = 1;
    //         }

    //         $data->title       = $request->title;
    //         $data->description = $request->description;

    //         $data->save();

    //         return redirect()->route('naturePageMetaTag.create')->with('success', 'Data Saved/Updated Successfully');

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
        $metaTags  = NaturePageMetaTag::get()->keyBy('lang_id');

        return view('backend.layout.tazim.naturePageMetaTag.create', compact('languages', 'metaTags'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'title'       => 'required',
                'description' => 'required',
                'lang_id'     => 'required|exists:languages,id',
            ]);

            // Find existing meta tag for this language
            $data = NaturePageMetaTag::firstOrNew(['lang_id' => $request->lang_id]);

            $data->title       = $request->title;
            $data->description = $request->description;
            $data->lang_id     = $request->lang_id;

            $data->save();

            return redirect()->route('naturePageMetaTag.create')
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
