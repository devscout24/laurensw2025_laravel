<?php
namespace App\Http\Controllers\Web\backend\tazim;

use App\Http\Controllers\Controller;
use App\Models\OurStory;
use Illuminate\Http\Request;

class OurStoryController extends Controller
{
    public function create()
    {
        $data = OurStory::whereId(1)->first();
        return view('backend.layout.tazim.ourStory.create', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'header'      => 'required|min:3',
            'title'       => 'required',
            'description' => 'required',
            'image'       => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $data = OurStory::find(1);

        if (! $data) {
            $data     = new OurStory();
            $data->id = 1;
        }

        $data->header      = $request->header;
        $data->title       = $request->title;
        $data->description = $request->description;

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if (! empty($data->image) && file_exists(public_path($data->image))) {
                unlink(public_path($data->image));
            }

            $file     = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('backend/images/ourStory'), $filename);
            $data->image = 'backend/images/ourStory/' . $filename;
        }

        $data->save(); // Always save (insert or update)

        return redirect()->route('ourstory.create')->with('success', 'Data Saved/Updated Successfully');
    }
}
