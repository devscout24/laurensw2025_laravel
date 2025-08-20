<?php

namespace App\Http\Controllers\Web\backend\tazim;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\PopularNatureTour;

class PopularNatureTourController extends Controller
{
    // public function create()
    // {
    //     $natureData = PopularNatureTour::whereId(1)->first();
    //     // dd('hello');
    //     return view('backend.layout.tazim.homeTour.create', compact('natureData'));
    // }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'header'       => 'required|max:100',
            'title'        => 'required|max:500',
        ]);

        if ($validate->fails()) {
            return redirect()->back()->with('error', $validate->errors()->first())->withInput();
        }

        $data = PopularNatureTour::find(1);

        if (! $data) {
            $data     = new PopularNatureTour();
            $data->id = 1;
        }

        $data->header   = $request->header;
        $data->title    = $request->title;

        $data->save();
        return redirect()->back()->with('success', 'Header & Title Added Successfully');
    }
}
