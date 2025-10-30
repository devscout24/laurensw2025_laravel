<?php
namespace App\Http\Controllers\Web\backend\tazim;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\SeoTitle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class SeoTitleController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = SeoTitle::with('language');

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('description', function ($row) {
                    return Str::words(strip_tags($row->description), 15, '...');
                })
                ->addColumn('language', function ($row) {
                    return $row->language->name ?? 'Not Defined';
                })
                ->addColumn('action', function ($data) {
                    return '<a class="btn btn-sm btn-warning" href="' . route('seoTitle.edit', ['id' => $data->id]) . '">
                            <i class="fa-solid fa-pencil"></i>
                        </a>
                        <a class="btn btn-sm btn-info" href="' . route('seoTitle.show', ['id' => $data->id]) . '">
                            <i class="fa-solid fa-eye"></i>
                        </a>';
                })
                ->order(function ($query) {
                    $query->orderBy('id', 'desc');
                })
                ->rawColumns(['description', 'language', 'action'])
                ->make(true);
        }

        return view('backend.layout.tazim.seoTitle.index');
    }

    // public function getData(Request $request)
    // {
    //     if ($request->ajax()) {
    //         $data = SeoTitle::orderBy('id', 'desc')->get();
    //         return DataTables::of($data)
    //             ->addIndexColumn()
    //             ->addColumn('description', function ($row) {
    //                 return Str::words(strip_tags($row->description), 15, '...');
    //             })
    //             ->addColumn('language', function ($row) {
    //                 return $row->language->name ?? 'Not Defined';
    //             })
    //             ->addColumn('action', function ($data) {
    //                 return '<a class="btn btn-sm btn-warning" href="' . route('seoTitle.edit', ['id' => $data->id]) . '">
    //                                         <i class="fa-solid fa-pencil"></i>
    //                                     </a>
    //                         <a class="btn btn-sm btn-info" href="' . route('seoTitle.show', ['id' => $data->id]) . '">
    //                                         <i class="fa-solid fa-eye"></i>
    //                                     </a>
    //                         ';
    //             })
    //             ->setRowAttr([
    //                 'data-id' => function ($data) {
    //                     return $data->id;
    //                 },
    //             ])
    //             ->rawColumns(['description', 'language', 'action'])
    //             ->make(true);
    //     }

    // }

    // public function create()
    // {
    //     $data = SeoTitle::all();
    //     return view('backend.layout.tazim.seoTitle.create', compact('data'));
    // }

    // public function store(Request $request)
    // {
    //     try {
    //         if (SeoTitle::count() >= 3) {
    //             return redirect()->back()->with('error', 'Maximum of 3 features allowed.');
    //         }

    //         $validator = Validator::make($request->all(), [
    //             'title'       => 'required|max:50',
    //             'description' => 'nullable|string',
    //         ]);

    //         if ($validator->fails()) {
    //             return redirect()->back()->with('error', $validator->errors()->first())->withInput();
    //         }

    //         $data              = new SeoTitle();
    //         $data->title       = $request->title;
    //         $data->description = $request->description;
    //         $data->save();

    //         return redirect()->route('seoTitle.list')->with('success', 'Created Successfully');

    //     } catch (Exception $e) {
    //         Log::error('SeoTitle store failed: ' . $e->getMessage(), [
    //             'trace' => $e->getTraceAsString(),
    //             'input' => $request->all(),
    //         ]);

    //         return redirect()->back()->with('error', 'Something went wrong while saving the SEO title.')->withInput();
    //     }
    // }

    public function show($id)
    {
        $data = SeoTitle::find($id);
        return view('backend.layout.tazim.seoTitle.show', compact('data'));
    }

    public function edit($id)
    {
        $data      = SeoTitle::findOrFail($id);
        $languages = Language::all();
        return view('backend.layout.tazim.seoTitle.edit', compact('data', 'languages'));
    }

    public function update(Request $request, $id)
    {
        try {
            $data = SeoTitle::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'title'       => 'required|max:50',
                'description' => 'nullable|string',
                'lang_id'     => 'required|exists:languages,id',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors()->first())->withInput();
            }

            $data->title       = $request->title;
            $data->description = $request->description;
            $data->lang_id     = $request->lang_id;
            $data->save();

            return redirect()->route('seoTitle.list')->with('success', 'Updated Successfully');

        } catch (\Exception $e) {
            Log::error('SeoTitle update failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'id'    => $id,
                'input' => $request->all(),
            ]);

            return redirect()->back()->with('error', 'Something went wrong while updating the SEO title.')->withInput();
        }
    }

    public function delete($id)
    {
        $data = SeoTitle::findOrFail($id);

        $data->delete();

        return redirect()->route('seoTitle.list')->with('success', 'Deleted Successfully');
    }
}
