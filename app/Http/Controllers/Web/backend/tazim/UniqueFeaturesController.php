<?php

namespace App\Http\Controllers\Web\backend\tazim;

use App\Http\Controllers\Controller;
use App\Models\UniqueFeatures;
use App\Models\WhatMakesUsDiffHead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class UniqueFeaturesController extends Controller
{
    public function index()
    {
        $data = UniqueFeatures::all();
        return view('backend.layout.tazim.unique-features.index', compact('data'));
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $data = UniqueFeatures::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('image', function ($row) {
                    return '<img src="' . asset($row->image) . '" width="35" alt="">';
                })
                ->addColumn('description', function ($row) {
                    return Str::words(strip_tags($row->description), 8, '...');
                })
                ->addColumn('action', function ($data) {
                    return '<a class="btn btn-sm btn-info" href="' . route('uniqueFeatures.edit', ['id' => $data->id]) . '">
                                            <i class="fa-solid fa-pencil"></i>
                                        </a>
                            <button type="button"  onclick="deleteData(\'' . route('uniqueFeatures.delete', $data->id) . '\')" class="btn btn-danger del">
                                <i class="mdi mdi-delete"></i>
                            </button>';
                })
                ->setRowAttr([
                    'data-id' => function ($data) {
                        return $data->id;
                    },
                ])
                ->rawColumns(['image', 'description', 'action'])
                ->make(true);
        }
    }

    public function create()
    {
        $data = WhatMakesUsDiffHead::whereId(1)->first();
        return view('backend.layout.tazim.unique-features.create', compact('data'));
    }

    public function store(Request $request)
    {
        // Prevent adding more than 6 entries
        if (UniqueFeatures::count() >= 6) {
            return redirect()->back()->with('error', 'Maximum of 6 features allowed.');
        }

        $validator = Validator::make($request->all(), [
            'heading'     => 'required|max:50',
            'image'       => 'required|file|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'description' => 'required|max:1000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first())->withInput();
        }

        $data              = new UniqueFeatures();
        $data->heading     = $request->heading;
        $data->description = $request->description;

        if ($request->hasFile('image')) {
            $file     = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('backend/images/uniqueFeatures'), $filename);
            $data->image = 'backend/images/uniqueFeatures/' . $filename;
        }

        $data->save();

        return redirect()->route('uniqueFeatures.list')->with('success', 'Created Successfully');
    }

    public function storeHeader(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'header'       => 'required|max:100',
            'title'        => 'required|max:500',
        ]);

        if ($validate->fails()) {
            return redirect()->back()->with('error', $validate->errors()->first())->withInput();
        }

        $data = WhatMakesUsDiffHead::find(1);

        if (! $data) {
            $data     = new WhatMakesUsDiffHead();
            $data->id = 1;
        }

        $data->header   = $request->header;
        $data->title    = $request->title;

        $data->save();
        return redirect()->back()->with('success', 'Header & Title Added Successfully');
    }

    public function edit($id)
    {
        $data = UniqueFeatures::find($id);
        return view('backend.layout.tazim.unique-features.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $data = UniqueFeatures::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'heading'     => 'required|max:50',
            'image'       => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'description' => 'required|max:500',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first())->withInput();
        }

        $data->heading = $request->heading;
        $data->description = $request->description;

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if (! empty($data->image) && file_exists(public_path($data->image))) {
                unlink(public_path($data->image));
            }

            // Upload new image
            $file     = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('backend/images/uniqueFeatures'), $filename);
            $data->image = 'backend/images/uniqueFeatures/' . $filename;
        }

        $data->save();

        return redirect()->route('uniqueFeatures.list')->with('success', 'Updated Successfully');
    }

    public function delete($id)
    {
        $data = UniqueFeatures::findOrFail($id);

        if (! empty($data->image) && file_exists(public_path($data->image))) {
            unlink(public_path($data->image));
        }

        $data->delete();

        return redirect()->route('uniqueFeatures.list')->with('success', 'Deleted Successfully');
    }
}
