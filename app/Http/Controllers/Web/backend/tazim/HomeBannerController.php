<?php
namespace App\Http\Controllers\Web\backend\tazim;

use App\Http\Controllers\Controller;
use App\Models\HomeBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class HomeBannerController extends Controller
{
    public function create()
    {
        $data = HomeBanner::whereId(1)->first();
        return view('backend.layout.tazim.homeBanner.create', compact('data'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'header'                => 'required|max:100',
            'title'                 => 'required|max:500',
            'image'                 => 'required|file|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'experience'            => 'required|integer',
            'happy_travelers'       => 'required|integer',
            'number_of_destination' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first())->withInput();
        }

        $data = HomeBanner::find(1);

        if (! $data) {
            $data     = new HomeBanner();
            $data->id = 1;
        }

        $data->header                = $request->header;
        $data->title                 = $request->title;
        $data->experience            = $request->experience;
        $data->happy_travelers       = $request->happy_travelers;
        $data->number_of_destination = $request->number_of_destination;

        if ($request->hasFile('image')) {
            if (! empty($data->image) && file_exists(public_path($data->image))) {
                unlink(public_path($data->image));
            }

            $file     = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('backend/images/homeBanner'), $filename);
            $data->image = 'backend/images/homeBanner/' . $filename;
        }
        $data->save();

        return redirect()->route('homeBanner.create')->with('success', 'Created Successfully');

    }
}
