<?php
namespace App\Http\Controllers\Web\backend\tazim;

use App\Http\Controllers\Controller;
use App\Models\Rating;
use App\Models\RatingHead;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class RatingController extends Controller
{
    public function index()
    {
        return view('backend.layout.tazim.rating.index');
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $data = Rating::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('image', function ($row) {
                    return '<img src="' . asset($row->image) . '" width="35" alt="">';
                })
                ->addColumn('description', function ($row) {
                    return Str::words(strip_tags($row->description), 15, '...');
                })

                ->addColumn('rating', function ($row) {
                    $stars = '';
                    for ($i = 1; $i <= 5; $i++) {
                        $stars .= '<i class="fa fa-star' . ($i <= $row->rating ? ' text-warning' : ' text-muted') . '"></i>';
                    }
                    return $stars;
                })
                ->addColumn('action', function ($data) {
                    return '<a class="btn btn-sm btn-warning" href="' . route('rating.edit', ['id' => $data->id]) . '">
                                            <i class="fa-solid fa-pencil"></i>
                                        </a>
                            <a class="btn btn-sm btn-info" href="' . route('rating.show', ['id' => $data->id]) . '">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                            <button type="button"  onclick="deleteData(\'' . route('rating.delete', $data->id) . '\')" class="btn btn-danger del">
                                <i class="mdi mdi-delete"></i>
                            </button>';
                })
                ->setRowAttr([
                    'data-id' => function ($data) {
                        return $data->id;
                    },
                ])
                ->rawColumns(['image', 'description', 'rating', 'action'])
                ->make(true);
        }

    }

    public function create()
    {
        $data = RatingHead::whereId(1)->first();
        return view('backend.layout.tazim.rating.create', compact('data'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'        => 'required|max:50',
            'designation' => 'nullable|max:50',
            'image'       => 'required|file|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'description' => 'required|max:1000',
            'rating'      => 'required|numeric|min:0.5|max:5',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first())->withInput();
        }

        try {
            DB::transaction(function () use ($request) {
                $data              = new Rating();
                $data->name        = $request->name;
                $data->designation = $request->designation ?? null;
                $data->rating      = round($request->rating, 1);
                $data->description = $request->description;

                if ($request->hasFile('image')) {
                    $file     = $request->file('image');
                    $filename = time() . '.' . $file->getClientOriginalExtension();
                    $path     = public_path('backend/images/rating');

                    // Ensure directory exists
                    if (! file_exists($path)) {
                        mkdir($path, 0755, true);
                    }

                    $file->move($path, $filename);
                    $data->image = 'backend/images/rating/' . $filename;
                }

                $data->save();
            });

            return redirect()->route('rating.list')->with('success', 'Rating created successfully.');
        } catch (\Exception $e) {
            return redirect()->route('rating.list')->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    public function storeHeader(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'header' => 'required|max:100',
                'title'  => 'required|max:500',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors()->first())->withInput();
            }

            $data = RatingHead::find(1);

            if (! $data) {
                $data     = new RatingHead();
                $data->id = 1;
            }

            $data->header = $request->header;
            $data->title  = $request->title;

            $data->save();

            return redirect()->back()->with('success', 'Header & Title Added Successfully');

        } catch (Exception $e) {
            Log::error('RatingHead storeHeader failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'input' => $request->all(),
            ]);

            return redirect()->back()->with('error', 'Something went wrong while saving the header & title.')->withInput();
        }
    }

    public function edit($id)
    {
        $data = Rating::findOrFail($id);
        return view('backend.layout.tazim.rating.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name'        => 'required|max:50',
            'designation' => 'nullable|max:50',
            'image'       => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'description' => 'required|max:1000',
            'rating'      => 'required|numeric|min:0.5|max:5',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first())->withInput();
        }

        try {
            DB::transaction(function () use ($request, $id) {
                $data              = Rating::findOrFail($id);
                $data->name        = $request->name;
                $data->designation = $request->designation ?? null;
                $data->rating      = round($request->rating, 1); // Round to 1 decimal place
                $data->description = $request->description;

                if ($request->hasFile('image')) {
                    // Delete old image if exists
                    if (! empty($data->image) && file_exists(public_path($data->image))) {
                        unlink(public_path($data->image));
                    }

                    $file     = $request->file('image');
                    $filename = time() . '.' . $file->getClientOriginalExtension();
                    $path     = public_path('backend/images/rating');

                    if (! file_exists($path)) {
                        mkdir($path, 0755, true);
                    }

                    $file->move($path, $filename);
                    $data->image = 'backend/images/rating/' . $filename;
                }

                $data->save();
            });

            return redirect()->route('rating.list')->with('success', 'Rating created successfully.');
        } catch (\Exception $e) {
            return redirect()->route('rating.list')->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $data = Rating::find($id);
        return view('backend.layout.tazim.rating.show', compact('data'));
    }

    public function delete($id)
    {
        $delete = Rating::find($id)->delete();
        if ($delete) {
            return back()->with('success', 'Deleted Successfully');
        } else {
            return back()->with('error', 'Try Again!');
        }
    }

}
