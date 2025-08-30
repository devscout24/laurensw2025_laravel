<?php
namespace App\Http\Controllers\Web\backend\tazim;

use App\Http\Controllers\Controller;
use App\Models\ResponsibleTravel;
use App\Models\ResponsibleTravelHead;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class ResponsibleTravelController extends Controller
{
    public function index()
    {
        $data = ResponsibleTravel::all();
        return view('backend.layout.tazim.responsible-travel.index', compact('data'));
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $data = ResponsibleTravel::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('image', function ($row) {
                    return '<img src="' . asset($row->image) . '" width="35" alt="">';
                })
                ->addColumn('description', function ($row) {
                    return Str::words(strip_tags($row->description), 8, '...');
                })
                ->addColumn('action', function ($data) {
                    return '<a class="btn btn-sm btn-warning" href="' . route('responsibleTravel.edit', ['id' => $data->id]) . '">
                                            <i class="fa-solid fa-pencil"></i>
                                        </a>';
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
        $data              = ResponsibleTravelHead::whereId(1)->first();
        $responsibleTravel = ResponsibleTravel::all();
        return view('backend.layout.tazim.responsible-travel.create', compact('data', 'responsibleTravel'));
    }

    public function store(Request $request)
    {
        try {
            if (ResponsibleTravel::count() >= 3) {
                return redirect()->back()->with('error', 'Maximum of 3 features allowed.');
            }

            $validator = Validator::make($request->all(), [
                'heading'     => 'required|max:50',
                'image'       => 'required|file|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
                'description' => 'required|max:1000',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors()->first())->withInput();
            }

            $data              = new ResponsibleTravel();
            $data->heading     = $request->heading;
            $data->description = $request->description;

            if ($request->hasFile('image')) {
                $file     = $request->file('image');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('backend/images/responsibleTravel'), $filename);
                $data->image = 'backend/images/responsibleTravel/' . $filename;
            }

            $data->save();

            return redirect()->route('responsibleTravel.list')->with('success', 'Created Successfully');

        } catch (Exception $e) {
            Log::error('ResponsibleTravel store failed: ' . $e->getMessage(), [
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

            $data = ResponsibleTravelHead::find(1);

            if (! $data) {
                $data     = new ResponsibleTravelHead();
                $data->id = 1;
            }

            $data->header = $request->header;
            $data->title  = $request->title;

            $data->save();

            return redirect()->back()->with('success', 'Header & Title Added Successfully');

        } catch (Exception $e) {
            Log::error('ResponsibleTravelHead storeHeader failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'input' => $request->all(),
            ]);

            return redirect()->back()->with('error', 'Something went wrong while saving the header & title.')->withInput();
        }
    }

    public function edit($id)
    {
        $data = ResponsibleTravel::find($id);
        return view('backend.layout.tazim.responsible-travel.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        try {
            $data = ResponsibleTravel::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'heading'     => 'required|max:50',
                'image'       => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
                'description' => 'required|max:500',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors()->first())->withInput();
            }

            $data->heading     = $request->heading;
            $data->description = $request->description;

            if ($request->hasFile('image')) {
                if (! empty($data->image) && file_exists(public_path($data->image))) {
                    unlink(public_path($data->image));
                }

                $file     = $request->file('image');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('backend/images/responsibleTravel'), $filename);
                $data->image = 'backend/images/responsibleTravel/' . $filename;
            }

            $data->save();

            return redirect()->route('responsibleTravel.list')->with('success', 'Updated Successfully');

        } catch (Exception $e) {
            Log::error('ResponsibleTravel update failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'input' => $request->all(),
                'id'    => $id,
            ]);

            return redirect()->back()->with('error', 'Something went wrong while updating the record.')->withInput();
        }
    }

    // public function delete($id)
    // {
    //     $data = ResponsibleTravel::findOrFail($id);

    //     if (! empty($data->image) && file_exists(public_path($data->image))) {
    //         unlink(public_path($data->image));
    //     }

    //     $data->delete();

    //     return redirect()->back()->with('success', 'Deleted Successfully');
    // }
}
