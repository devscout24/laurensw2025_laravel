<?php
namespace App\Http\Controllers\Web\backend\tazim;

use App\Http\Controllers\Controller;
use App\Models\ShipCabins;
use App\Models\ShipView;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class ShipCabinsController extends Controller
{
    public function index(Request $request): View | JsonResponse
    {
        // Load cabins with their associated ShipView (for ship name)
        $data = ShipCabins::with('shipView')->get();

        if ($request->ajax()) {
            $data = ShipCabins::with('shipView')->latest()->get();

            return DataTables::of($data)
                ->addIndexColumn()

            // Show image
                ->addColumn('image', function ($data) {
                    $image = $data->image ? asset($data->image) : asset('images/default.png');
                    return '<img src="' . $image . '" width="35" alt="Cabin Image"/>';
                })

            // Show Ship Name instead of ID
                ->addColumn('ship', function ($data) {
                    return $data->shipView ? $data->shipView->name : 'N/A';
                })

            // Show cabin type with proper label
                ->addColumn('cabin_type', function ($data) {
                    $types = [
                        'oceanview'  => 'Ocean View',
                        'belcony'    => 'Balcony',
                        'interior'   => 'Interior',
                        'royalsuite' => 'Royal Suite Class',
                    ];
                    return $types[$data->cabin_type] ?? ucfirst($data->cabin_type ?? 'N/A');
                })

            // Shortened description
                ->addColumn('description', function ($data) {
                    return $data->description
                        ? Str::limit(strip_tags($data->description), 30, '...')
                        : 'N/A';
                })

            // Actions
                ->addColumn('action', function ($data) {
                    return '<div class="btn-group btn-group-sm" role="group">
                            <a href="' . route('shipCabin.edit', $data->id) . '" class="btn btn-primary text-white" title="Edit">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <a href="' . route('shipCabin.show', $data->id) . '" class="btn btn-warning text-white" title="View">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            <a href="#" onclick="showDeleteConfirm(' . $data->id . ')" class="btn btn-danger text-white" title="Delete">
                                <i class="fa-regular fa-trash-can"></i>
                            </a>
                        </div>';
                })

                ->rawColumns(['image', 'description', 'action'])
                ->make(true);
        }

        return view('backend.layout.tazim.shipCabins.index', compact('data'));
    }

    public function create()
    {
        $ships = ShipView::select('id', 'name')->orderBy('name')->get();
        return view('backend.layout.tazim.shipCabins.create', compact('ships'));
    }

    /**
     * Store new cabin.
     */

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'shipview_id' => 'required|exists:ship_views,id',
                'cabin_type'  => 'required|in:oceanview,balcony,interior,royalsuite',
                'description' => 'nullable|string|max:2000',
                'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            ], [
                'shipview_id.required' => 'Please select a ship.',
                'shipview_id.exists'   => 'Selected ship not found.',
                'cabin_type.required'  => 'Cabin type is required.',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors()->first())->withInput();
            }

            $cabin              = new ShipCabins(); // ensure model name is ShipCabin
            $cabin->shipview_id = $request->shipview_id;
            $cabin->cabin_type  = $request->cabin_type;
            $cabin->description = $request->description;

            if ($request->hasFile('image')) {
                $file     = $request->file('image');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $path     = public_path('backend/images/shipCabins');

                if (! file_exists($path)) {
                    mkdir($path, 0777, true);
                }

                $file->move($path, $filename);
                $cabin->image = 'backend/images/shipCabins/' . $filename;
            }

            $cabin->save();

            return redirect()->route('shipCabin.index', $request->shipview_id)->with('success', 'Cabin added successfully.');
        } catch (\Exception $e) {
            Log::error('ShipCabin store failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'input' => $request->all(),
            ]);
            return redirect()->route('shipCabin.index')->with('error', 'Something went wrong while saving the cabin.' . $e->getMessage())->withInput();
        }
    }

    /**
     * Show the edit form.
     */
    public function edit($id)
    {
        $data  = ShipCabins::findOrFail($id);
        $ships = ShipView::all(); // so user can change ship association if needed
        return view('backend.layout.tazim.shipCabins.edit', compact('data', 'ships'));
    }

    /**
     * Update existing cabin.
     */
    public function update(Request $request, $id)
    {
        try {
            $cabin = ShipCabins::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'shipview_id' => 'required|exists:ship_views,id',
                'cabin_type'  => 'required|in:oceanview,balcony,interior,royalsuite',
                'description' => 'nullable|string|max:2000',
                'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            ], [
                'shipview_id.required' => 'Ship selection is required.',
                'description.max'      => 'Description cannot exceed 2000 characters.',
                'image.max'            => 'Image must not exceed 2MB.',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors()->first())->withInput();
            }

            $cabin->shipview_id = $request->shipview_id;
            $cabin->cabin_type  = $request->cabin_type;
            $cabin->description = $request->description;

            if ($request->hasFile('image')) {
                if (! empty($cabin->image) && file_exists(public_path($cabin->image))) {
                    unlink(public_path($cabin->image));
                }

                $file     = $request->file('image');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $path     = public_path('backend/images/shipCabins');

                if (! file_exists($path)) {
                    mkdir($path, 0777, true);
                }

                $file->move($path, $filename);
                $cabin->image = 'backend/images/shipCabins/' . $filename;
            }

            $cabin->save();

            return redirect()->route('shipCabin.index', $cabin->shipview_id)
                ->with('success', 'Cabin updated successfully.');
        } catch (\Exception $e) {
            Log::error('ShipCabin update failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'input' => $request->all(),
            ]);
            return redirect()->route('shipCabin.index')->with('error', 'Something went wrong while updating the cabin.' . $e->getMessage())->withInput();
        }
    }

    public function show($id)
    {
        $data  = ShipCabins::findOrFail($id);
        // $ships = ShipView::all();
        return view('backend.layout.tazim.shipCabins.show', compact('data'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $data = shipCabins::findOrFail($id);
            $data->delete();

            return response()->json([
                'success' => true,
                'message' => 'Deleted successfully.',
            ]);
        } catch (\Exception) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete the Data.',
            ]);
        }
    }

}
