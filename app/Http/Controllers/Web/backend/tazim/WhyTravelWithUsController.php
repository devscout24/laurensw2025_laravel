<?php
namespace App\Http\Controllers\Web\backend\tazim;

use App\Http\Controllers\Controller;
use App\Models\WhyTravelWithUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class WhyTravelWithUsController extends Controller
{
    public function index()
    {
        return view('backend.layout.tazim.why-travel-with-us.index');
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $data = WhyTravelWithUs::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
            // ->addColumn('title', function ($row) {
            //     return Str::words(strip_tags($row->title), 15, '...');
            // })
                ->addColumn('action', function ($data) {
                    return '<a class="btn btn-sm btn-warning" href="' . route('whyTravelWithUs.edit', ['id' => $data->id]) . '">
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
        return view('backend.layout.tazim.why-travel-with-us.create');
    }

    public function store(Request $request)
    {
        if (WhyTravelWithUs::count() >= 2) {
            return redirect()->back()->with('error', 'Maximum of 2 features allowed.');
        }

        $validator = Validator::make($request->all(), [
            'header'       => 'required|max:50',
            'title'        => 'nullable|max:100',
            'description1' => 'nullable|max:150',
            'description2' => 'nullable|max:150',
            'description3' => 'nullable|max:150',
            'description4' => 'nullable|max:150',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first())->withInput();
        }

        $data               = new WhyTravelWithUs();
        $data->header       = $request->header;
        $data->title        = $request->title;
        $data->description1 = $request->description1;
        $data->description2 = $request->description2;
        $data->description3 = $request->description3;
        $data->description4 = $request->description4;

        $data->save();

        return redirect()->route('whyTravelWithUs.list')->with('success', 'Created Successfully');
    }

    public function edit($id)
    {
        $data = WhyTravelWithUs::find($id);
        return view('backend.layout.tazim.why-travel-with-us.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $data = WhyTravelWithUs::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'header'       => 'required|max:50',
            'title'        => 'nullable|max:100',
            'description1' => 'nullable|max:150',
            'description2' => 'nullable|max:150',
            'description3' => 'nullable|max:150',
            'description4' => 'nullable|max:150',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first())->withInput();
        }

        $data->header       = $request->header;
        $data->title        = $request->title;
        $data->description1 = $request->description1;
        $data->description2 = $request->description2;
        $data->description3 = $request->description3;
        $data->description4 = $request->description4;

        $data->save();

        return redirect()->route('whyTravelWithUs.list')->with('success', 'Updated Successfully');
    }

    public function delete($id)
    {
        $data = WhyTravelWithUs::findOrFail($id);

        $data->delete();

        return redirect()->route('whyTravelWithUs.list')->with('success', 'Deleted Successfully');
    }

}
