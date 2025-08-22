<?php

namespace App\Http\Controllers\Web\backend\tazim;

use App\Http\Controllers\Controller;
use App\Models\TravelAdvisor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class TravelAdvisorController extends Controller
{
    public function index()
    {
        return view('backend.layout.tazim.traveladvisor.index');
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $data = TravelAdvisor::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('image', function ($row) {
                    return '<img src="' . asset($row->image) . '" width="35" alt="">';
                })
                ->addColumn('action', function ($data) {
                    return '<a class="btn btn-sm btn-info" href="' . route('travelAdvisor.edit', ['id' => $data->id]) . '">
                                            <i class="fa-solid fa-pencil"></i>
                                        </a>
                                        <button type="button"  onclick="deleteData(\'' . route('travelAdvisor.delete', $data->id) . '\')" class="btn btn-danger del">
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
        return view('backend.layout.tazim.traveladvisor.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'          => 'required|max:100',
            'designation'   => 'required|',
            'experience'    => 'required|numeric',
            'trip_success'  => 'required|numeric',
            'whatsapp'      => 'nullable',
            'image'         => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first())->withInput();
        }

        $data = new TravelAdvisor();
        $data->name          = $request->name;
        $data->designation   = $request->designation;
        $data->experience    = $request->experience;
        $data->trip_success  = $request->trip_success;
        $data->whatsapp      = $request->whatsapp;
        // $data->slug          = Str::slug($request->name, '-');

        if ($request->hasFile('image')) {
            $file     = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('backend/images/travelAdvisor'), $filename);
            $data->image = 'backend/images/travelAdvisor/' . $filename;
        }

        $data->save();
        return redirect()->route('travelAdvisor.list')->with('success', 'Travel Advisor Added Successfully');
    }

    public function edit($id)
    {
        $data = TravelAdvisor::findOrFail($id);
        return view('backend.layout.tazim.traveladvisor.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name'          => 'required|max:100',
            'designation'   => 'required|',
            'experience'    => 'required',
            'trip_success'  => 'required',
            'whatsapp'      => 'nullable',
            'image'         => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first())->withInput();
        }

        $data = TravelAdvisor::findOrFail($id);
        $data->name          = $request->name;
        $data->designation   = $request->designation;
        $data->experience    = $request->experience;
        $data->trip_success  = $request->trip_success;
        $data->whatsapp      = $request->whatsapp;
        // $data->slug          = Str::slug($request->name, '-');

        if ($request->hasFile('image')) {
            $file     = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('backend/images/travelAdvisor'), $filename);
            $data->image = 'backend/images/travelAdvisor/' . $filename;
        }

        $data->save();
        return redirect()->route('travelAdvisor.list')->with('success', 'Travel Advisor Updated Successfully');
    }

    public function detete($id)
    {
        $data = TravelAdvisor::findOrFail($id);

        if ($data->image && file_exists(public_path($data->image))) {
            unlink(public_path($data->image));
        }

        $data->delete();
        return redirect()->back()->with('success', 'Travel Advisor Deleted Successfully');
    }
}
