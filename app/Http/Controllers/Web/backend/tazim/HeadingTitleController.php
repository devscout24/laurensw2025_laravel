<?php
namespace App\Http\Controllers\Web\backend\tazim;

use App\Http\Controllers\Controller;
use App\Models\HeadingTitle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class HeadingTitleController extends Controller
{
    public function index()
    {
        $data = HeadingTitle::all();
        return view('backend.layout.tazim.heading-title.index', compact('data'));
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $data = HeadingTitle::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('title', function ($row) {
                    return Str::words(strip_tags($row->title), 15, '...');
                })
                ->addColumn('action', function ($data) {
                    return '<a class="btn btn-sm btn-warning" href="' . route('headingTitle.edit', ['id' => $data->id]) . '">
                                            <i class="fa-solid fa-pencil"></i>
                                        </a>
                            <a class="btn btn-sm btn-info" href="' . route('headingTitle.show', ['id' => $data->id]) . '">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                            ';
                })
                // <button type="button"  onclick="deleteData(\'' . route('headingTitle.delete', $data->id) . '\')" class="btn btn-danger del">
                //                 <i class="mdi mdi-delete"></i>
                //             </button>
                ->setRowAttr([
                    'data-id' => function ($data) {
                        return $data->id;
                    },
                ])
                ->rawColumns(['title', 'action'])
                ->make(true);
        }

    }

    public function create()
    {
        return view('backend.layout.tazim.heading-title.create');
    }

    public function store(Request $request)
    {
        if (HeadingTitle::count() >= 21) {
            return redirect()->back()->with('error', 'Maximum of 21 features allowed.');
        }

        $validator = Validator::make($request->all(), [
            'heading'           => 'required|max:50',
            'title'             => 'nullable|max:1000',
            'description'       => 'nullable|max:1000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first())->withInput();
        }

        $data                  = new HeadingTitle();
        $data->heading         = $request->heading;
        $data->title           = $request->title;
        $data->description     = $request->description;

        $data->save();

        return back()->with('success', 'Created Successfully');
    }

        public function show($id)
    {
        $data = HeadingTitle::find($id);
        return view('backend.layout.tazim.heading-title.show', compact('data'));
    }

    public function edit($id)
    {
        $data = HeadingTitle::find($id);
        return view('backend.layout.tazim.heading-title.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $data = HeadingTitle::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'heading'           => 'required|max:50',
            'title'             => 'nullable|max:1000',
            'description'       => 'nullable|max:1000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first())->withInput();
        }

        $data->heading         = $request->heading;
        $data->title           = $request->title;
        $data->description     = $request->description;

        $data->save();

        return redirect()->back()->with('success', 'Updated Successfully');
    }

    public function delete($id)
    {
        $data = HeadingTitle::findOrFail($id);

        $data->delete();

        return redirect()->back()->with('success', 'Deleted Successfully');
    }
}
