<?php
namespace App\Http\Controllers\Web\backend\tazim;

use App\Http\Controllers\Controller;
use App\Models\ShipDecks;
use App\Models\ShipView;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class ShipDecksController extends Controller
{
    public function index(Request $request): View | JsonResponse
    {
        $data = ShipDecks::with('shipView')->get();

        if ($request->ajax()) {
            $data = ShipDecks::with('shipView')->latest()->get();

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
                            <a href="' . route('shipDeck.edit', $data->id) . '" class="btn btn-primary text-white" title="Edit">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <a href="' . route('shipDeck.show', $data->id) . '" class="btn btn-warning text-white" title="View">
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

        return view('backend.layout.tazim.shipDeck.index', compact('data'));
    }

    public function create()
    {
        $ships = ShipView::select('id', 'name')->orderBy('name')->get();
        return view('backend.layout.tazim.shipDeck.create', compact('ships'));
    }

    /**
     * Store new cabin.
     */

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'shipview_id' => 'required|exists:ship_views,id',
                'title'   => 'nullable|string|max:20',
                'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            ], [
                'shipview_id.required' => 'Please select a ship.',
                'title.max'            => 'title cannot exceed 20 characters.',
                'image.max'            => 'Image must not exceed 2MB.',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors()->first())->withInput();
            }

            $data              = new ShipDecks(); // ensure model name is Shipdata
            $data->shipview_id = $request->shipview_id;
            $data->title       = $request->title;

            if ($request->hasFile('image')) {
                $file     = $request->file('image');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $path     = public_path('backend/images/shipDeck');

                if (! file_exists($path)) {
                    mkdir($path, 0777, true);
                }

                $file->move($path, $filename);
                $data->image = 'backend/images/shipDeck/' . $filename;
            }

            $data->save();

            return redirect()->route('shipDeck.index', $request->shipview_id)->with('success', 'Deck added successfully.');
        } catch (\Exception $e) {
            Log::error('Amenity store failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'input' => $request->all(),
            ]);
            return redirect()->route('shipDeck.index')->with('error', 'Something went wrong while saving the Deck.' . $e->getMessage())->withInput();
        }
    }

    /**
     * Show the edit form.
     */
    public function edit($id)
    {
        $data  = ShipDecks::findOrFail($id);
        $ships = ShipView::all(); // so user can change ship association if needed
        return view('backend.layout.tazim.shipDeck.edit', compact('data', 'ships'));
    }

    /**
     * Update existing cabin.
     */
    public function update(Request $request, $id)
    {
        try {
            $data = ShipDecks::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'shipview_id' => 'required|exists:ship_views,id',
                'title'       => 'nullable|string|max:20',
                'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            ], [
                'shipview_id.required' => 'Please select a ship.',
                'title.max'            => 'title cannot exceed 20 characters.',
                'image.max'            => 'Image must not exceed 2MB.',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors()->first())->withInput();
            }

            $data->shipview_id = $request->shipview_id;
            $data->title   = $request->title;

            if ($request->hasFile('image')) {
                if (! empty($data->image) && file_exists(public_path($data->image))) {
                    unlink(public_path($data->image));
                }

                $file     = $request->file('image');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $path     = public_path('backend/images/shipDeck');

                if (! file_exists($path)) {
                    mkdir($path, 0777, true);
                }

                $file->move($path, $filename);
                $data->image = 'backend/images/shipDeck/' . $filename;
            }

            $data->save();

            return redirect()->route('shipDeck.index', $data->shipview_id)
                ->with('success', 'Amenity updated successfully.');
        } catch (\Exception $e) {
            Log::error('Amenity update failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'input' => $request->all(),
            ]);
            return redirect()->route('shipDeck.index')->with('error', 'Something went wrong while updating the Deck.' . $e->getMessage())->withInput();
        }
    }

    public function show($id)
    {
        $data = ShipDecks::findOrFail($id);
        return view('backend.layout.tazim.shipDeck.show', compact('data'));
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
            $data = ShipDecks::findOrFail($id);
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
