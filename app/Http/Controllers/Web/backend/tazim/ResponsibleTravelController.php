<?php
namespace App\Http\Controllers\Web\backend\tazim;

use App\Http\Controllers\Controller;
use App\Models\ResponsibleTravel;
use Illuminate\Http\Request;
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
                    return '<a class="btn btn-sm btn-info" href="' . route('responsibleTravel.edit', ['id' => $data->id]) . '">
                                            <i class="fa-solid fa-pencil"></i>
                                        </a>
                            <button type="button"  onclick="deleteData(\'' . route('responsibleTravel.delete', $data->id) . '\')" class="btn btn-danger del">
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
        return view('backend.layout.tazim.responsible-travel.create');
    }

    public function store(Request $request)
    {
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

        return back()->with('success', 'Created Successfully');
    }

    public function edit($id)
    {
        $data = ResponsibleTravel::find($id);
        return view('backend.layout.tazim.responsible-travel.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
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
            // Delete old image if exists
            if (! empty($data->image) && file_exists(public_path($data->image))) {
                unlink(public_path($data->image));
            }

            // Upload new image
            $file     = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('backend/images/responsibleTravel'), $filename);
            $data->image = 'backend/images/responsibleTravel/' . $filename;
        }

        $data->save();

        return redirect()->back()->with('success', 'Updated Successfully');
    }

    public function delete($id)
    {
        $data = ResponsibleTravel::findOrFail($id);

        if (! empty($data->image) && file_exists(public_path($data->image))) {
            unlink(public_path($data->image));
        }

        $data->delete();

        return redirect()->back()->with('success', 'Deleted Successfully');
    }
}
