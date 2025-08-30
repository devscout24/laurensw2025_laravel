<?php
namespace App\Http\Controllers\Web\backend\tazim;

use App\Http\Controllers\Controller;
use App\Models\SinglePageBanner;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;use Yajra\DataTables\DataTables;

class SinglePageBannerController extends Controller
{
    public function index()
    {
        return view('backend.layout.tazim.singlePageBanner.index');
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $data = SinglePageBanner::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('image', function ($row) {
                    return '<img src="' . asset($row->image) . '" width="35" alt="">';
                })
                ->addColumn('action', function ($data) {
                    return '<a class="btn btn-sm btn-warning" href="' . route('singlePageBanner.edit', ['id' => $data->id]) . '">
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

    public function edit($id)
    {
        $data = SinglePageBanner::find($id);
        return view('backend.layout.tazim.singlePageBanner.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        try {
            $validate = Validator::make($request->all(), [
                'title' => 'required|max:50',
                'image' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,webp|max:5000',
            ]);

            if ($validate->fails()) {
                return redirect()->back()->with('error', $validate->errors()->first())->withInput();
            }

            $data        = SinglePageBanner::findOrFail($id);
            $data->title = $request->title;

            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($data->image && file_exists(public_path($data->image))) {
                    unlink(public_path($data->image));
                }

                // Save new image
                $file     = $request->file('image');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('backend/images/singlePageBanner'), $filename);

                $data->image = 'backend/images/singlePageBanner/' . $filename;
            }

            $data->save();

            return redirect()->route('singlePageBanner.list')->with('success', 'Banner Updated Successfully');

        } catch (Exception $e) {
            Log::error('SinglePageBanner update failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'id'    => $id,
                'input' => $request->all(),
            ]);

            return redirect()->back()->with('error', 'Something went wrong while updating the banner.')->withInput();
        }
    }
}
