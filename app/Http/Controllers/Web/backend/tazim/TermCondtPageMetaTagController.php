<?php

namespace App\Http\Controllers\Web\backend\tazim;

use App\Http\Controllers\Controller;
use App\Models\TermCondtPageMetaTag;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TermCondtPageMetaTagController extends Controller
{
        public function create()
    {
        $data = TermCondtPageMetaTag::whereId(1)->first();
        return view('backend.layout.tazim.termCondtPageMetaTag.create', compact('data'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'title'       => 'required',
                'description' => 'required',
            ]);

            $data = TermCondtPageMetaTag::find(1);

            if (! $data) {
                $data     = new TermCondtPageMetaTag();
                $data->id = 1;
            }

            $data->title       = $request->title;
            $data->description = $request->description;

            $data->save();

            return redirect()->route('termCondtPageMetaTag.create')->with('success', 'Data Saved/Updated Successfully');

        } catch (Exception $e) {
            Log::error('Data store/update failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'input' => $request->all(),
            ]);

            return redirect()->back()->with('error', 'Something went wrong while saving the data.')->withInput();
        }
    }
}
