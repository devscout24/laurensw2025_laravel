<?php
namespace App\Http\Controllers\Web\backend\tazim;

use App\Http\Controllers\Controller;
use App\Models\ShipAmenities;
use App\Models\ShipView;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class ShipAmenitiesController extends Controller
{
    public function index(Request $request): View | JsonResponse
    {
        $data = ShipAmenities::with('shipView')->get();

        if ($request->ajax()) {
            $data = ShipAmenities::with('shipView')->latest()->get();

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

            // Actions
                ->addColumn('action', function ($data) {
                    return '<div class="btn-group btn-group-sm" role="group">
                            <a href="' . route('shipAmenity.edit', $data->id) . '" class="btn btn-primary text-white" title="Edit">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <a href="' . route('shipAmenity.show', $data->id) . '" class="btn btn-warning text-white" title="View">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            <a href="#" onclick="showDeleteConfirm(' . $data->id . ')" class="btn btn-danger text-white" title="Delete">
                                <i class="fa-regular fa-trash-can"></i>
                            </a>
                        </div>';
                })

                ->rawColumns(['image', 'action'])
                ->make(true);
        }

        return view('backend.layout.tazim.shipAmenities.index', compact('data'));
    }

    public function create()
    {
        $ships = ShipView::select('id', 'name')->orderBy('name')->get();
        return view('backend.layout.tazim.shipAmenities.create', compact('ships'));
    }

    /**
     * Store new cabin.
     */

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'shipview_id' => 'required|exists:ship_views,id',
                'amenities'   => 'nullable|string|max:20',
                'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            ], [
                'shipview_id.required' => 'Please select a ship.',
                'amenities.max'        => 'Amenities cannot exceed 20 characters.',
                'image.max'            => 'Image must not exceed 2MB.',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors()->first())->withInput();
            }

            $data              = new ShipAmenities(); // ensure model name is Shipdata
            $data->shipview_id = $request->shipview_id;
            $data->amenities   = $request->amenities;

            if ($request->hasFile('image')) {
                $file     = $request->file('image');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $path     = public_path('backend/images/shipAmenities');

                if (! file_exists($path)) {
                    mkdir($path, 0777, true);
                }

                $file->move($path, $filename);
                $data->image = 'backend/images/shipAmenities/' . $filename;
            }

            $data->save();

            return redirect()->route('shipAmenity.index', $request->shipview_id)->with('success', 'Amenity added successfully.');
        } catch (\Exception $e) {
            Log::error('Amenity store failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'input' => $request->all(),
            ]);
            return redirect()->route('shipAmenity.index')->with('error', 'Something went wrong while saving the Amenity.' . $e->getMessage())->withInput();
        }
    }

    /**
     * Show the edit form.
     */
    public function edit($id)
    {
        $data  = ShipAmenities::findOrFail($id);
        $ships = ShipView::all(); // so user can change ship association if needed
        return view('backend.layout.tazim.shipAmenities.edit', compact('data', 'ships'));
    }

    /**
     * Update existing cabin.
     */
    public function update(Request $request, $id)
    {
        try {
            $data = ShipAmenities::findOrFail($id);

            $validator = Validator::make($request->all(), [
               'shipview_id' => 'required|exists:ship_views,id',
                'amenities'   => 'nullable|string|max:20',
                'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            ], [
                'shipview_id.required' => 'Please select a ship.',
                'amenities.max'        => 'Amenities cannot exceed 20 characters.',
                'image.max'            => 'Image must not exceed 2MB.',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors()->first())->withInput();
            }

            $data->shipview_id = $request->shipview_id;
            $data->amenities   = $request->amenities;

            if ($request->hasFile('image')) {
                if (! empty($data->image) && file_exists(public_path($data->image))) {
                    unlink(public_path($data->image));
                }

                $file     = $request->file('image');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $path     = public_path('backend/images/shipAmenities');

                if (! file_exists($path)) {
                    mkdir($path, 0777, true);
                }

                $file->move($path, $filename);
                $data->image = 'backend/images/shipAmenities/' . $filename;
            }

            $data->save();

            return redirect()->route('shipAmenity.index', $data->shipview_id)
                ->with('success', 'Amenity updated successfully.');
        } catch (\Exception $e) {
            Log::error('Amenity update failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'input' => $request->all(),
            ]);
            return redirect()->route('shipAmenity.index')->with('error', 'Something went wrong while updating the amenity.' . $e->getMessage())->withInput();
        }
    }

    public function show($id)
    {
        $data = ShipAmenities::findOrFail($id);
        return view('backend.layout.tazim.shipAmenities.show', compact('data'));
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
            $data = ShipAmenities::findOrFail($id);
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
