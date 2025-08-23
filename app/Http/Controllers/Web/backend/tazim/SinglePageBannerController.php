<?php

namespace App\Http\Controllers\Web\backend\tazim;

use App\Http\Controllers\Controller;
use App\Models\SinglePageBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class SinglePageBannerController extends Controller
{
    public function index()
    {
        // $data = SinglePageBanner::latest()->get();
        return view('backend.layout.tazim.singlePageBanner.index');
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $data = SinglePageBanner::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('image', function ($row) {
                    return '<img src="' . asset($row->image) . '" width="35" alt="">';
                })
                ->addColumn('action', function ($data) {
                    return '<a class="btn btn-sm btn-info" href="' . route('singlePageBanner.edit', ['id' => $data->id]) . '">
                                            <i class="fa-solid fa-pencil"></i>
                                        </a>';
                })
                ->setRowAttr([
                    'data-id' => function ($data) {
                        return $data->id;
                    },
                ])
                ->rawColumns(['image', 'action'])
                ->make(true);
        }
    }

    public function edit($id)
    {
        $data = SinglePageBanner::find($id);
        return view('backend.layout.tazim.singlePageBanner.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $validate = Validator::make($request->all(), [
            'title' => 'required|max:50 ',
            'image' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        if ($validate->fails()) {
            return redirect()->back()->with('error', $validate->errors()->first())->withInput();
        }

        $data = SinglePageBanner::findOrFail($id);
        $data->title = $request->title;

        if ($request->hasFile('image')) {
            // delete old image if exists
            if ($data->image && file_exists(public_path($data->image))) {
                unlink(public_path($data->image));
            }

            // save new image
            $file     = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('backend/images/singlePageBanner'), $filename);

            $data->image = 'backend/images/singlePageBanner/' . $filename;
        }

        $data->save();

        return redirect()->route('singlePageBanner.list')->with('success', 'Banner Updated Successfully');
    }
}
