<?php

namespace App\Http\Controllers\Web\backend\tazim;

use App\Http\Controllers\Controller;
use App\Models\HomeExperienceSectionImages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class HomeExperienceSectionImagesController extends Controller
{
    public function index()
    {
        $data = HomeExperienceSectionImages::all();
        return view('backend.layout.tazim.homeExperienceSection.index' , compact('data'));
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $data = HomeExperienceSectionImages::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('image', function ($row) {
                    return '<img src="' . asset($row->image) . '" width="35" alt="">';
                })
                ->addColumn('action', function ($data) {
                    return '<a class="btn btn-sm btn-warning" href="' . route('homeExperienceImageSection.edit', ['id' => $data->id]) . '">
                                            <i class="fa-solid fa-pencil"></i>
                                        </a>                            
                            <button type="button"  onclick="deleteData(\'' . route('homeExperienceImageSection.delete', $data->id) . '\')" class="btn btn-danger del">
                                <i class="mdi mdi-delete"></i>
                            </button>';
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

    public function create()
    {
        return view('backend.layout.tazim.homeExperienceSection.create');
    }

    public function store(Request $request)
    {
        if (HomeExperienceSectionImages::count() >= 6) {
            return redirect()->back()->with('error', 'Maximum of 6 images allowed.');
        }

        $validator = Validator::make($request->all(), [
            'name'         => 'required|max:10',
            'image'        => 'required|file|mimes:jpeg,png,jpg,gif,svg,webp,avif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first())->withInput();
        }

        $data = new HomeExperienceSectionImages();
        $data ->name   = $request->name;

        if ($request->hasFile('image')) {
            $file     = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('backend/images/homeExperienceSection'), $filename);
            $data->image = 'backend/images/homeExperienceSection/' . $filename;
        }
        $data->save();
        return redirect()->route('homeExperienceImageSection.list')->with('success', 'Image Added Successfully');
    }

    public function edit($id)
    {
        $data = HomeExperienceSectionImages::findOrFail($id);
        return view('backend.layout.tazim.homeExperienceSection.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name'         => 'required|max:10',
            'image'        => 'file|mimes:jpeg,png,jpg,gif,svg,webp,avif|max:2048'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first())->withInput();
        }

        $data = HomeExperienceSectionImages::findOrFail($id);
        $data ->name   = $request->name;

        if ($request->hasFile('image')) {
            $file     = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('backend/images/homeExperienceSection'), $filename);
            $data->image = 'backend/images/homeExperienceSection/' . $filename;
        }
        $data->save();
        return redirect()->route('homeExperienceImageSection.list')->with('success', 'Image Updated Successfully');
    }
}
