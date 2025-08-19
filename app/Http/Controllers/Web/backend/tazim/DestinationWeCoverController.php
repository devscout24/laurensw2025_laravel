<?php
namespace App\Http\Controllers\Web\backend\tazim;

use App\Http\Controllers\Controller;
use App\Models\DestinationWeCover;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class DestinationWeCoverController extends Controller
{
    public function index()
    {
        $data = DestinationWeCover::all();
        return view('backend.layout.tazim.destination-we-cover.index', compact('data'));
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $data = DestinationWeCover::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('image', function ($row) {
                    return '<img src="' . asset($row->image) . '" width="35" alt="">';
                })
                ->addColumn('url', function ($row) {
                    return Str::limit(strip_tags($row->url), 30, '...');
                })

                ->addColumn('action', function ($data) {
                    return '<a class="btn btn-sm btn-warning" href="' . route('destinationCover.edit', ['id' => $data->id]) . '">
                                            <i class="fa-solid fa-pencil"></i>
                                        </a>
                            <a class="btn btn-sm btn-info" href="' . route('destinationCover.show', ['id' => $data->id]) . '">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                            ';
                })
                // <button type="button"  onclick="deleteData(\'' . route('destinationCover.delete', $data->id) . '\')" class="btn btn-danger del">
                //                 <i class="mdi mdi-delete"></i>
                //             </button>
                ->setRowAttr([
                    'data-id' => function ($data) {
                        return $data->id;
                    },
                ])
                ->rawColumns(['image', 'url', 'action'])
                ->make(true);
        }

    }

    public function create()
    {
        return view('backend.layout.tazim.destination-we-cover.create');
    }

    public function store(Request $request)
    {
        if (DestinationWeCover::count() >= 3) {
            return redirect()->back()->with('error', 'Maximum of 3 features allowed.');
        }

        $validator = Validator::make($request->all(), [
            'image' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'title' => 'nullable|max:1000',
            'url'   => 'nullable|max:200',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first())->withInput();
        }

        $data        = new DestinationWeCover();
        $data->image = $request->image;
        $data->title = $request->title;
        $data->url   = $request->url;

        if ($request->hasFile('image')) {
            if (! empty($data->image) && file_exists(public_path($data->image))) {
                unlink(public_path($data->image));
            }

            $file     = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('backend/images/destinationWeCover'), $filename);
            $data->image = 'backend/images/destinationWeCover/' . $filename;
        }

        $data->save();

        return redirect()->route('destinationCover.list')->with('success', 'Created Successfully');
    }

    public function show($id)
    {
        $data = DestinationWeCover::find($id);
        return view('backend.layout.tazim.destination-we-cover.show', compact('data'));
    }

    public function edit($id)
    {
        $data = DestinationWeCover::find($id);
        return view('backend.layout.tazim.destination-we-cover.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $data = DestinationWeCover::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'image' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'title' => 'required|max:1000',
            'url'   => 'nullable|max:200',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first())->withInput();
        }

        $data->title = $request->title;
        $data->url   = $request->url;

        if ($request->hasFile('image')) {
            // Delete old file if exists
            if (! empty($data->image) && file_exists(public_path($data->image))) {
                unlink(public_path($data->image));
            }

            $file     = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('backend/images/destinationWeCover'), $filename);
            $data->image = 'backend/images/destinationWeCover/' . $filename;
        }

        $data->save();

        return redirect()->route('destinationCover.list')->with('success', 'Updated Successfully');
    }

    public function delete($id)
    {
        $data = DestinationWeCover::findOrFail($id);

        if (! empty($data->image) && file_exists(public_path($data->image))) {
            unlink(public_path($data->image));
        }

        $data->delete();

        return redirect()->back()->with('success', 'Deleted Successfully');
    }
}
