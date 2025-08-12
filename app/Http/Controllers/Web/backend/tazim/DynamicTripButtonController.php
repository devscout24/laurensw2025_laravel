<?php
namespace App\Http\Controllers\Web\backend\tazim;

use App\Http\Controllers\Controller;
use App\Models\DynamicTripButton;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class DynamicTripButtonController extends Controller
{
    public function index()
    {
        return view('backend.layout.tazim.dynamic-trip-button.index');
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $data = DynamicTripButton::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
            // ->addColumn('title', function ($row) {
            //     return Str::words(strip_tags($row->title), 15, '...');
            // })
                ->addColumn('action', function ($data) {
                    return '<a class="btn btn-sm btn-warning" href="' . route('dynamicTripButton.edit', ['id' => $data->id]) . '">
                                            <i class="fa-solid fa-pencil"></i>
                                        </a> ';
                })
            // <button type="button"  onclick="deleteData(\'' . route('headingTitle.delete', $data->id) . '\')" class="btn btn-danger del">
            //                 <i class="mdi mdi-delete"></i>
            //             </button>
                ->setRowAttr([
                    'data-id' => function ($data) {
                        return $data->id;
                    },
                ])
                ->rawColumns(['action'])
                ->make(true);
        }

    }

    public function create()
    {
        return view('backend.layout.tazim.dynamic-trip-button.create');
    }

    public function store(Request $request)
    {
        if (DynamicTripButton::count() >= 3) {
            return redirect()->back()->with('error', 'Maximum of 3 features allowed.');
        }

        $validator = Validator::make($request->all(), [
            'button_name' => 'required|max:35|unique:dynamic_trip_buttons,column,except,id',
            'trip_url'    => 'required',
            'trip_id'     => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first())->withInput();
        }

        $data              = new DynamicTripButton();
        $data->button_name = $request->button_name;
        $data->trip_url    = $request->trip_url;
        $data->trip_id     = $request->trip_id;
        $data->save();

        return back()->with('success', 'Created Successfully');
    }

    public function edit($id)
    {
        $data = DynamicTripButton::find($id);
        return view('backend.layout.tazim.dynamic-trip-button.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $data = DynamicTripButton::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'button_name' => 'required|max:35',
            'trip_url'    => 'required',
            'trip_id'     => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first())->withInput();
        }

        $data->button_name = $request->button_name;
        $data->trip_url    = $request->trip_url;
        $data->trip_id     = $request->trip_id;
        $data->save();

        return redirect()->back()->with('success', 'Updated Successfully');
    }
}
