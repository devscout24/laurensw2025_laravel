<?php
namespace App\Http\Controllers\Web\backend\tazim;

use App\Http\Controllers\Controller;
use App\Models\AboutPageMetaTag;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AboutPageMetaTagController extends Controller
{
    public function create()
    {
        $data = AboutPageMetaTag::whereId(1)->first();
        return view('backend.layout.tazim.aboutPageMetaTag.create', compact('data'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'title'       => 'required',
                'description' => 'required',
            ]);

            $data = AboutPageMetaTag::find(1);

            if (! $data) {
                $data     = new AboutPageMetaTag();
                $data->id = 1;
            }

            $data->title       = $request->title;
            $data->description = $request->description;

            $data->save();

            return redirect()->route('aboutPageMetaTag.create')->with('success', 'Data Saved/Updated Successfully');

        } catch (Exception $e) {
            Log::error('Data store/update failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'input' => $request->all(),
            ]);

            return redirect()->back()->with('error', 'Something went wrong while saving the data.')->withInput();
        }
    }
}
