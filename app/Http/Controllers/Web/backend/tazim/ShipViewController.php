<?php
namespace App\Http\Controllers\Web\backend\tazim;

use App\Http\Controllers\Controller;
use App\Models\ShipView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class ShipViewController extends Controller
{
    public function index()
    {
        $data = ShipView::latest()->get();
        return view('backend.layout.tazim.shipView.index', compact('data'));
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $data = ShipView::orderBy('id', 'desc')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('image', function ($row) {
                    $defaultImage = asset('frontend/no-image.jpg');

                    if ($row->image && file_exists(public_path($row->image))) {
                        $imagePath = asset($row->image);
                    } else {
                        $imagePath = $defaultImage;
                    }

                    return '<img src="' . $imagePath . '" width="35" alt="">';
                })
                ->addColumn('name', function ($row) {
                    return Str::limit($row->name, 30); // limit to 30 characters
                })
                ->addColumn('description', function ($row) {
                    return Str::limit($row->description, 40); // limit to 40 characters
                })
                ->addColumn('action', function ($data) {
                    return '<a class="btn btn-sm btn-warning" href="' . route('shipView.edit', ['id' => $data->id]) . '">
                            <i class="fa-solid fa-pencil"></i>
                        </a>
                        <a class="btn btn-sm btn-info" href="' . route('shipView.show', ['id' => $data->id]) . '">
                            <i class="fa-solid fa-eye"></i>
                        </a>
                        <button type="button"  onclick="deleteData(\'' . route('shipView.delete', $data->id) . '\')" class="btn btn-danger del">
                                <i class="mdi mdi-delete"></i>
                            </button>';
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
        return view('backend.layout.tazim.shipView.create');
    }

    public function store(Request $request)
    {
        try {
            // Validation
            $validator = Validator::make($request->all(), [
                'name'          => 'required|string|max:255',
                'description'   => 'nullable|string|max:2000',
                'build_year'    => 'nullable|digits:4|integer|min:1600|max:' . date('Y'),
                'crew_number'   => 'nullable|integer|min:0',
                'max_guests'    => 'nullable|integer|min:0',
                'length'        => 'nullable|numeric|min:0',
                'zodiac_boats'  => 'nullable|string|min:0',
                'capacity'      => 'nullable|integer|min:0',
                'comfort_level' => 'nullable|in:standard,premium,luxury',
                'price'         => 'nullable|numeric|min:0',
                'image'         => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            ], [
                'name.required'     => 'Ship name is required.',
                'name.max'          => 'Ship name cannot exceed 255 characters.',
                'build_year.digits' => 'Build year must be exactly 4 digits.',
                'image.mimes'       => 'Image must be jpeg, png, jpg, gif, or webp.',
                'image.max'         => 'Image size must not exceed 2MB.',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $data                = new ShipView();
            $data->name          = $request->name;
            $data->description   = $request->description;
            $data->build_year    = $request->build_year;
            $data->crew_number   = $request->crew_number;
            $data->max_guests    = $request->max_guests;
            $data->length        = $request->length;
            $data->zodiac_boats  = $request->zodiac_boats;
            $data->capacity      = $request->capacity;
            $data->comfort_level = $request->comfort_level;
            $data->price         = $request->price;

            // ✅ Manual Image Upload
            if ($request->hasFile('image')) {
                $file     = $request->file('image');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $path     = public_path('backend/images/shipView');

                if (! file_exists($path)) {
                    mkdir($path, 0777, true);
                }

                if (! is_writable($path)) {
                    throw new \Exception("Directory not writable: " . $path);
                }

                $file->move($path, $filename);
                $data->image = 'backend/images/shipView/' . $filename;
            }

            $data->save();

            return redirect()->route('shipView.list')->with('success', 'Ship added successfully.');
        } catch (\Exception $e) {
            Log::error('Ship store failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'input' => $request->all(),
            ]);

            return redirect()->route('shipView.list')->with('error', 'Something went wrong while adding the ship.' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $data = ShipView::findOrFail($id);
        return view('backend.layout.tazim.shipView.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        try {
            $data = ShipView::findOrFail($id);

            // ✅ Validation
            $validator = Validator::make($request->all(), [
                'name'          => 'required|string|max:255',
                'description'   => 'required|string',
                'build_year'    => 'nullable|string|max:10',
                'crew_number'   => 'nullable|string|max:10',
                'max_guests'    => 'nullable|string|max:10',
                'length'        => 'nullable|string|max:50',
                'zodiac_boats'  => 'nullable|string|min:0',
                'capacity'      => 'nullable|string|max:50',
                'comfort_level' => 'nullable|string|in:standard,premium,luxury',
                'price'         => 'nullable|string|max:50',
                'image'         => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            ], [
                'name.required'     => 'Ship name is required.',
                'name.max'          => 'Ship name cannot exceed 255 characters.',
                'build_year.digits' => 'Build year must be exactly 4 digits.',
                'image.max'         => 'Image size must not exceed 2MB.',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            // ✅ Update fields
            $data->name          = $request->name;
            $data->description   = $request->description;
            $data->build_year    = $request->build_year;
            $data->crew_number   = $request->crew_number;
            $data->max_guests    = $request->max_guests;
            $data->length        = $request->length;
            $data->zodiac_boats  = $request->zodiac_boats;
            $data->capacity      = $request->capacity;
            $data->comfort_level = $request->comfort_level;
            $data->price         = $request->price;

            // ✅ Handle image upload
            if ($request->hasFile('image')) {
                // delete old image if exists
                if (! empty($data->image) && file_exists(public_path($data->image))) {
                    unlink(public_path($data->image));
                }

                $file     = $request->file('image');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $path     = public_path('backend/images/shipView');

                if (! file_exists($path)) {
                    mkdir($path, 0777, true);
                }

                $file->move($path, $filename);
                $data->image = 'backend/images/shipView/' . $filename;
            }

            $data->save();

            return redirect()->route('shipView.list')->with('success', 'Ship updated successfully!');

        } catch (\Exception $e) {
            Log::error('ShipView update failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'input' => $request->all(),
                'id'    => $id,
            ]);
            return redirect()->route('shipView.list')->with('error', 'Something went wrong while updating the ship. ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $data = ShipView::find($id);
        return view('backend.layout.tazim.shipView.show', compact('data'));
    }

    public function delete($id)
    {
        $delete = ShipView::find($id)->delete();
        if ($delete) {
            return back()->with('success', 'Deleted Successfully');
        } else {
            return back()->with('error', 'Try Again!');
        }
    }

}
