<?php
namespace App\Http\Controllers\Web\backend\tazim;

use App\Http\Controllers\Controller;
use App\Models\HomeTour;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;

class HomeTourController extends Controller
{
    public function index()
    {
        $data = HomeTour::all();
        return view('backend.layout.tazim.homeTour.index', compact('data'));
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $data = HomeTour::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('title', function ($row) {
                    return Str::words(strip_tags($row->title), 15, '...');
                })
                ->addColumn('image', function ($row) {
                    return '<img src="' . asset($row->image) . '" width="35" alt="">';
                })
                ->addColumn('action', function ($data) {
                    return '<a class="btn btn-sm btn-warning" href="' . route('homeTour.edit', ['id' => $data->id]) . '">
                                            <i class="fa-solid fa-pencil"></i>
                                        </a>                            
                            <button type="button"  onclick="deleteData(\'' . route('homeTour.delete', $data->id) . '\')" class="btn btn-danger del">
                                <i class="mdi mdi-delete"></i>
                            </button>';
                })

                ->setRowAttr([
                    'data-id' => function ($data) {
                        return $data->id;
                    },
                ])
                ->rawColumns(['title', 'image', 'action'])
                ->make(true);
        }

    }

    public function create()
    {
        return view('backend.layout.tazim.homeTour.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'header'       => 'required|max:100',
            'title'        => 'required|max:500',
            'image'        => 'required|file|mimes:jpeg,png,jpg,gif,svg,webp,avif|max:2048',
            'duration'     => 'required',
            'ship'         => 'required',
            'price'        => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first())->withInput();
        }

        $data = new HomeTour();
        $data->header   = $request->header;
        $data->title    = $request->title;
        $data->duration = $request->duration;
        $data->ship     = $request->ship;
        $data->price    = $request->price;

        if ($request->hasFile('image')) {
            if (! empty($data->image) && file_exists(public_path($data->image))) {
                unlink(public_path($data->image));
            }

            $file     = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('backend/images/homeTour'), $filename);
            $data->image = 'backend/images/homeTour/' . $filename;
        }
        $data->save();
        return redirect()->route('homeTour.list')->with('success', 'Home Tour Created Successfully');
    }

    public function edit($id)
    {
        $data = HomeTour::findOrFail($id);
        return view('backend.layout.tazim.homeTour.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $data = HomeTour::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'header'       => 'required|max:100',
            'title'        => 'required|max:500',
            'image'        => 'file|mimes:jpeg,png,jpg,gif,svg,webp,avif|max:2048',
            'duration'     => 'required',
            'ship'         => 'required',
            'price'        => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first())->withInput();
        }

        $data->header   = $request->header;
        $data->title    = $request->title;
        $data->duration = $request->duration;
        $data->ship     = $request->ship;
        $data->price    = $request->price;

        if ($request->hasFile('image')) {
            if (! empty($data->image) && file_exists(public_path($data->image))) {
                unlink(public_path($data->image));
            }

            $file     = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('backend/images/homeTour'), $filename);
            $data->image = 'backend/images/homeTour/' . $filename;
        }
        $data->save();
        return redirect()->route('homeTour.list')->with('success', 'Home Tour Updated Successfully');
    }

    public function delete($id)
    {
        $data = HomeTour::findOrFail($id);
        if (! empty($data->image) && file_exists(public_path($data->image))) {
            unlink(public_path($data->image));
        }
        $data->delete();
        return redirect()->route('homeTour.list')->with('success', 'Home Tour Deleted Successfully');
    }
}
