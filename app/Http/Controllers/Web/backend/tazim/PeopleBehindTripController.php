<?php
namespace App\Http\Controllers\Web\backend\tazim;

use App\Http\Controllers\Controller;
use App\Models\PeopleBehindTrip;
use App\Models\PeopleBehindTripHead;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class PeopleBehindTripController extends Controller
{
    public function index()
    {
        $data = PeopleBehindTrip::all();
        return view('backend.layout.tazim.peopleBehindTrip.index', compact('data'));
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $data = PeopleBehindTrip::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('image', function ($row) {
                    return '<img src="' . asset($row->image) . '" width="35" alt="">';
                })
                ->addColumn('action', function ($data) {
                    return '<a class="btn btn-sm btn-warning" href="' . route('peopleBehind.edit', ['id' => $data->id]) . '">
                                            <i class="fa-solid fa-pencil"></i>
                                        </a>
                            <a class="btn btn-sm btn-info" href="' . route('peopleBehind.show', ['id' => $data->id]) . '">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>';
                                        
                            // <button type="button"  onclick="deleteData(\'' . route('peopleBehind.delete', $data->id) . '\')" class="btn btn-danger del">
                            //     <i class="mdi mdi-delete"></i>
                            // </button>
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
        $data = PeopleBehindTripHead::whereId(1)->first();
        $peopleBehindTrip = PeopleBehindTrip::all();
        return view('backend.layout.tazim.peopleBehindTrip.create', compact('data', 'peopleBehindTrip'));
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'image'       => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
                'name'        => 'required',
                'designation' => 'required',
                'description' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors()->first())->withInput();
            }

            $data              = new PeopleBehindTrip();
            $data->name        = $request->name;
            $data->designation = $request->designation;
            $data->description = $request->description;

            if ($request->hasFile('image')) {
                if (! empty($data->image) && file_exists(public_path($data->image))) {
                    unlink(public_path($data->image));
                }

                $file     = $request->file('image');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('backend/images/peopleBehindTrip'), $filename);
                $data->image = 'backend/images/peopleBehindTrip/' . $filename;
            }

            $data->save();
            return redirect()->route('peopleBehind.list')->with('success', 'People Behind Trip Added Successfully');

        } catch (Exception $e) {
            Log::error('PeopleBehindTrip store failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'input' => $request->all(),
            ]);

            return redirect()->back()->with('error', 'Something went wrong while saving the data.')->withInput();
        }
    }

    public function storeHeader(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'header' => 'required|max:100',
                'title'  => 'required|max:500',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors()->first())->withInput();
            }

            $data = PeopleBehindTripHead::find(1);
            if (! $data) {
                $data     = new PeopleBehindTripHead();
                $data->id = 1;
            }

            $data->header = $request->header;
            $data->title  = $request->title;
            $data->save();

            return redirect()->back()->with('success', 'Header & Title Added Successfully');

        } catch (Exception $e) {
            Log::error('PeopleBehindTripHead storeHeader failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'input' => $request->all(),
            ]);

            return redirect()->back()->with('error', 'Something went wrong while saving the header & title.')->withInput();
        }
    }

    public function edit($id)
    {
        $data = PeopleBehindTrip::find($id);
        return view('backend.layout.tazim.peopleBehindTrip.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'image'       => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
                'name'        => 'required',
                'designation' => 'required',
                'description' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors()->first())->withInput();
            }

            $data              = PeopleBehindTrip::findOrFail($id);
            $data->name        = $request->name;
            $data->designation = $request->designation;
            $data->description = $request->description;

            if ($request->hasFile('image')) {
                if (! empty($data->image) && file_exists(public_path($data->image))) {
                    unlink(public_path($data->image));
                }

                $file     = $request->file('image');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('backend/images/peopleBehindTrip'), $filename);
                $data->image = 'backend/images/peopleBehindTrip/' . $filename;
            }

            $data->save();

            return redirect()->route('peopleBehind.list')->with('success', 'People Behind Trip Updated Successfully');

        } catch (Exception $e) {
            Log::error('PeopleBehindTrip update failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'input' => $request->all(),
                'id'    => $id,
            ]);

            return redirect()->back()->with('error', 'Something went wrong while updating the data.')->withInput();
        }
    }

    public function show($id)
    {
        $data = PeopleBehindTrip::find($id);
        return view('backend.layout.tazim.peopleBehindTrip.show', compact('data'));
    }

    public function delete($id)
    {
        $delete = PeopleBehindTrip::find($id)->delete();
        if ($delete) {
            return back()->with('success', 'Deleted Successfully');
        } else {
            return back()->with('error', 'Try Again!');
        }
    }
}
