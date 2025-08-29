<?php
namespace App\Http\Controllers\Web\backend\tazim;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\GalleryHead;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class GalleryController extends Controller
{
    public function index()
    {
        $data = Gallery::latest()->get();
        return view('backend.layout.tazim.gallery.index', compact('data'));
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $data = Gallery::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('image', function ($row) {
                    return '<img src="' . asset($row->image) . '" width="35" alt="">';
                })
                ->addColumn('action', function ($data) {
                    return '<a class="btn btn-sm btn-info" href="' . route('gallery.edit', ['id' => $data->id]) . '">
                                            <i class="fa-solid fa-pencil"></i>
                                        </a>';
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
        $data = GalleryHead::whereId(1)->first();
        return view('backend.layout.tazim.gallery.create', compact('data'));
    }

    public function store(Request $request)
    {
        try {
            if (Gallery::count() >= 6) {
                return redirect()->back()->with('error', 'Maximum of 6 features allowed.');
            }

            $validator = Validator::make($request->all(), [
                'image' => 'required|file|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors()->first())->withInput();
            }

            $data = new Gallery();

            if ($request->hasFile('image')) {
                $file     = $request->file('image');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('backend/images/gallery'), $filename);
                $data->image = 'backend/images/gallery/' . $filename;
            }

            $data->save();

            return redirect()->route('gallery.list')->with('success', 'Image Added Successfully');
        } catch (Exception $e) {
            Log::error('Gallery store failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'input' => $request->all(),
            ]);

            return redirect()->back()->with('error', 'Something went wrong while uploading the image.')->withInput();
        }
    }

    public function storeHeader(Request $request)
    {
        try {
            $validate = Validator::make($request->all(), [
                'header' => 'required|max:50',
            ]);

            if ($validate->fails()) {
                return redirect()->back()->with('error', $validate->errors()->first())->withInput();
            }

            $data = GalleryHead::find(1);

            if (! $data) {
                $data     = new GalleryHead();
                $data->id = 1;
            }

            $data->header = $request->header;
            $data->save();

            return redirect()->back()->with('success', 'Header & Title Added Successfully');
        } catch (Exception $e) {
            Log::error('Gallery header store failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'input' => $request->all(),
            ]);

            return redirect()->back()->with('error', 'Something went wrong while saving the header.')->withInput();
        }
    }

    public function edit($id)
    {
        $data = Gallery::findOrFail($id);
        return view('backend.layout.tazim.gallery.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        try {
            $validate = Validator::make($request->all(), [
                'image' => 'required|file|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            ]);

            if ($validate->fails()) {
                return redirect()->back()->with('error', $validate->errors()->first())->withInput();
            }

            $data = Gallery::findOrFail($id);

            if ($request->hasFile('image')) {
                $file     = $request->file('image');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('backend/images/gallery'), $filename);
                $data->image = 'backend/images/gallery/' . $filename;
            }

            $data->save();

            return redirect()->route('gallery.list')->with('success', 'Image Updated Successfully');
        } catch (Exception $e) {
            Log::error('Gallery update failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'input' => $request->all(),
                'id'    => $id,
            ]);

            return redirect()->back()->with('error', 'Something went wrong while updating the image.')->withInput();
        }
    }
}
