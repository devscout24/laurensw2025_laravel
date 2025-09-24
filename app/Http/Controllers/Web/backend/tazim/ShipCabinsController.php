<?php

namespace App\Http\Controllers\Web\backend\tazim;

use App\Http\Controllers\Controller;
use App\Models\ShipCabins;
use Illuminate\Http\Request;
use App\Models\ShipView;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class ShipCabinsController extends Controller
{
    public function index()
    {
        $data = ShipCabins::all();
        return view('backend.layout.tazim.shipCabins.index', compact('data'));
    }

    public function create($shipview_id)
    {
        $ship = ShipView::findOrFail($shipview_id);
        return view('backend.layout.tazim.shipCabins.create', compact('ship'));
    }

    /**
     * Store new cabin.
     */
    public function store(Request $request, $shipview_id)
    {
        try {
            $ship = ShipView::findOrFail($shipview_id);

            $validator = Validator::make($request->all(), [
                'cabin_type'  => 'required|in:standard,deluxe,suite,family',
                'description' => 'nullable|string|max:2000',
                'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            ], [
                'cabin_type.required' => 'Cabin type is required.',
                'cabin_type.in'       => 'Cabin type must be Standard, Deluxe, Suite, or Family.',
                'description.max'     => 'Description cannot exceed 2000 characters.',
                'image.image'         => 'Please upload a valid image.',
                'image.mimes'         => 'Image must be jpeg, png, jpg, gif, or webp.',
                'image.max'           => 'Image must not exceed 2MB.',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors()->first())->withInput();
            }

            $cabin = new ShipCabins();
            $cabin->shipview_id = $ship->id;
            $cabin->cabin_type  = $request->cabin_type;
            $cabin->description = $request->description;

            if ($request->hasFile('image')) {
                $file     = $request->file('image');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $path     = public_path('backend/images/shipCabins');

                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }

                $file->move($path, $filename);
                $cabin->image = 'backend/images/shipCabins/' . $filename;
            }

            $cabin->save();

            return redirect()->route('shipView.show', $ship->id)->with('success', 'Cabin added successfully.');
        } catch (\Exception $e) {
            Log::error('ShipCabin store failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'input' => $request->all(),
            ]);
            return redirect()->back()->with('error', 'Something went wrong while saving the cabin.')->withInput();
        }
    }

    /**
     * Show the edit form.
     */
    public function edit($id)
    {
        $cabin = ShipCabins::findOrFail($id);
        return view('backend.layout.tazim.shipCabins.edit', compact('cabin'));
    }

    /**
     * Update a cabin.
     */
    public function update(Request $request, $id)
    {
        try {
            $cabin = ShipCabins::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'cabin_type'  => 'required|in:standard,deluxe,suite,family',
                'description' => 'nullable|string|max:2000',
                'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors()->first())->withInput();
            }

            $cabin->cabin_type  = $request->cabin_type;
            $cabin->description = $request->description;

            if ($request->hasFile('image')) {
                if (!empty($cabin->image) && file_exists(public_path($cabin->image))) {
                    unlink(public_path($cabin->image));
                }

                $file     = $request->file('image');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $path     = public_path('backend/images/shipCabins');

                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }

                $file->move($path, $filename);
                $cabin->image = 'backend/images/shipCabins/' . $filename;
            }

            $cabin->save();

            return redirect()->route('shipView.show', $cabin->shipview_id)->with('success', 'Cabin updated successfully.');
        } catch (\Exception $e) {
            Log::error('ShipCabin update failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'input' => $request->all(),
            ]);
            return redirect()->back()->with('error', 'Something went wrong while updating the cabin.')->withInput();
        }
    }
}
