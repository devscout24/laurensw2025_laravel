<?php
namespace App\Http\Controllers\Web\backend\tazim;

use App\Http\Controllers\Controller;
use App\Models\ExperienceSectionImageHeader;
use App\Models\HomeExperienceSectionImages;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class HomeExperienceSectionImagesController extends Controller
{
    public function index()
    {
        $data = HomeExperienceSectionImages::all();
        return view('backend.layout.tazim.homeExperienceSection.index', compact('data'));
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $data = HomeExperienceSectionImages::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('image', function ($row) {
                    return '<img src="' . asset($row->image) . '" width="35" alt="">';
                })
                ->addColumn('action', function ($data) {
                    return '<a class="btn btn-sm btn-warning" href="' . route('homeExperienceImageSection.edit', ['id' => $data->id]) . '">
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
        $data = ExperienceSectionImageHeader::whereId(1)->first();
        return view('backend.layout.tazim.homeExperienceSection.create', compact('data'));
    }

    public function store(Request $request)
    {
        try {
            if (HomeExperienceSectionImages::count() >= 6) {
                return redirect()->back()->with('error', 'Maximum of 6 images allowed.');
            }

            $validator = Validator::make($request->all(), [
                'name'  => 'required|max:10',
                'image' => 'required|file|mimes:jpeg,png,jpg,gif,svg,webp,avif|max:2048',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors()->first())->withInput();
            }

            $data       = new HomeExperienceSectionImages();
            $data->name = $request->name;

            if ($request->hasFile('image')) {
                $file     = $request->file('image');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('backend/images/homeExperienceSection'), $filename);
                $data->image = 'backend/images/homeExperienceSection/' . $filename;
            }

            $data->save();

            return redirect()->route('homeExperienceImageSection.list')->with('success', 'Image Added Successfully');
        } catch (Exception $e) {
            Log::error('HomeExperienceSectionImages store failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'input' => $request->all(),
            ]);
            return redirect()->back()->with('error', 'Something went wrong while uploading the image.')->withInput();
        }
    }

    public function storeHeader(Request $request)
    {
        try {
            if (ExperienceSectionImageHeader::count() >= 1) {
                return redirect()->back()->with('error', 'Maximum of 1 features allowed.');
            }

            $validator = Validator::make($request->all(), [
                'header' => 'required|max:100',
                'title'  => 'required|max:500',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors()->first())->withInput();
            }

            $data = ExperienceSectionImageHeader::find(1);

            if (! $data) {
                $data     = new ExperienceSectionImageHeader();
                $data->id = 1;
            }

            $data->header = $request->header;
            $data->title  = $request->title;
            $data->save();

            return redirect()->back()->with('success', 'Header & Title Added Successfully');
        } catch (Exception $e) {
            Log::error('ExperienceSectionImageHeader storeHeader failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'input' => $request->all(),
            ]);
            return redirect()->back()->with('error', 'Something went wrong while saving header & title.')->withInput();
        }
    }

    public function edit($id)
    {
        $data = HomeExperienceSectionImages::findOrFail($id);
        return view('backend.layout.tazim.homeExperienceSection.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name'  => 'required|max:10',
                'image' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,webp,avif|max:2048',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors()->first())->withInput();
            }

            $data       = HomeExperienceSectionImages::findOrFail($id);
            $data->name = $request->name;

            if ($request->hasFile('image')) {
                // Delete old image if exists
                if (! empty($data->image) && file_exists(public_path($data->image))) {
                    unlink(public_path($data->image));
                }

                $file     = $request->file('image');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('backend/images/homeExperienceSection'), $filename);
                $data->image = 'backend/images/homeExperienceSection/' . $filename;
            }

            $data->save();

            return redirect()->route('homeExperienceImageSection.list')->with('success', 'Image Updated Successfully');
        } catch (Exception $e) {
            Log::error('HomeExperienceSectionImages update failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'input' => $request->all(),
            ]);
            return redirect()->back()->with('error', 'Something went wrong while updating the image.')->withInput();
        }
    }
}
