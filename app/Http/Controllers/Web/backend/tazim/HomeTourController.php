<?php
namespace App\Http\Controllers\Web\backend\tazim;

use App\Http\Controllers\Controller;
use App\Models\HomeTour;
use App\Models\PopularNatureTour;
use App\Models\Ship;
use App\Models\Trip;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

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
                    $defaultImage = asset('frontend/no-image.jpg');

                    if ($row->image && file_exists(public_path($row->image))) {
                        $imagePath = asset($row->image);
                    } else {
                        $imagePath = $defaultImage;
                    }
                    return '<img src="' . $imagePath . '" width="35" alt="">';
                })
                ->addColumn('action', function ($data) {
                    return '<a class="btn btn-sm btn-warning" href="' . route('homeTour.edit', ['id' => $data->id]) . '">
                                            <i class="fa-solid fa-pencil"></i>
                                        </a>';
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
        $natureData = PopularNatureTour::whereId(1)->first();
        $trips      = Trip::all();
        $homeTour   = HomeTour::all();
        return view('backend.layout.tazim.homeTour.create', compact('natureData', 'trips', 'homeTour'));
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'label'    => 'required|max:100',
                'header'   => 'required|max:100',
                'title'    => 'required|max:500',
                'trip_id'  => 'nullable|exists:trips,id', // ✅ validate trip_id
                'image'    => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,webp,avif|max:4096',
                'duration' => 'required',
                'ship'     => 'required',
                'price'    => 'required|numeric',
                'alt_tag'  => 'required|max:100',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors()->first())->withInput();
            }

            $data           = new HomeTour();
            $data->label    = $request->label;
            $data->header   = $request->header;
            $data->title    = $request->title;
            $data->duration = $request->duration;
            $data->ship     = $request->ship;
            $data->price    = $request->price;
            $data->alt_tag  = $request->alt_tag;
            $data->trip_id  = $request->trip_id; // ✅ save trip id from dropdown

            if ($request->hasFile('image')) {
                // Delete old image if exists (not needed on create, but safe check)
                if (! empty($data->image) && file_exists(public_path($data->image))) {
                    unlink(public_path($data->image));
                }

                $file     = $request->file('image');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $path     = public_path('backend/images/homeTour');

                if (! file_exists($path)) {
                    mkdir($path, 0777, true);
                }

                if (! is_writable($path)) {
                    throw new \Exception("Directory not writable: " . $path);
                }

                $file->move($path, $filename);
                $data->image = 'backend/images/homeTour/' . $filename;
            }

            $data->save();

            return redirect()->route('homeTour.list')->with('success', 'Home Tour Created Successfully');
        } catch (Exception $e) {
            Log::error('HomeTour store failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'input' => $request->all(),
            ]);
            return redirect()->back()->with('error', 'Something went wrong while creating Home Tour.')->withInput();
        }
    }

    public function edit($id)
    {
        $data  = HomeTour::findOrFail($id);
        $trips = Trip::all();
        return view('backend.layout.tazim.homeTour.edit', compact('data', 'trips'));
    }

    public function update(Request $request, $id)
    {
        try {
            $data = HomeTour::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'label'    => 'required|max:100',
                'header'   => 'required|max:100',
                'title'    => 'required|max:500',
                'image'    => 'file|mimes:jpeg,png,jpg,gif,svg,webp,avif|max:4096',
                'duration' => 'required',
                'ship'     => 'required',
                'price'    => 'required|numeric',
                'alt_tag'  => 'required|max:100',
                'trip_id'  => 'nullable|exists:trips,id',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors()->first())->withInput();
            }

            $data->label    = $request->label;
            $data->header   = $request->header;
            $data->title    = $request->title;
            $data->duration = $request->duration;
            $data->ship     = $request->ship;
            $data->price    = $request->price;
            $data->alt_tag  = $request->alt_tag;
            $data->trip_id  = $request->trip_id;

            if ($request->hasFile('image')) {
                if (! empty($data->image) && file_exists(public_path($data->image))) {
                    unlink(public_path($data->image));
                }

                $file     = $request->file('image');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $path     = public_path('backend/images/homeTour');

                if (! file_exists($path)) {
                    mkdir($path, 0777, true);
                }

                if (! is_writable($path)) {
                    throw new \Exception("Directory not writable: " . $path);
                }

                $file->move($path, $filename);
                $data->image = 'backend/images/homeTour/' . $filename;
            }

            $data->save();

            return redirect()->route('homeTour.list')->with('success', 'Home Tour Updated Successfully');
        } catch (Exception $e) {
            Log::error('HomeTour update failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'input' => $request->all(),
            ]);

            return redirect()->back()->with('error', 'Something went wrong while updating Home Tour.')->withInput();
        }
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
