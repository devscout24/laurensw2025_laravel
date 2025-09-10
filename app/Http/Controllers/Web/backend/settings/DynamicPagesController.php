<?php

namespace App\Http\Controllers\Web\backend\settings;

use App\Helper\Helper;
use App\Models\DynamicPage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class DynamicPagesController extends Controller
{
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $data = DynamicPage::latest()->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('bulk_check', function ($data) {
                    return '<div class="form-checkbox">
                                <input type="checkbox" class="form-check-input select_data"
                                       id="checkbox-' . $data->id . '"
                                       value="' . $data->id . '"
                                       onClick="select_single_item(' . $data->id . ')">
                                <label class="form-check-label" for="checkbox-' . $data->id . '"></label>
                            </div>';
                })
                ->editColumn('page_content', function ($data) {
                    return Str::limit(strip_tags($data->page_content), 50);
                })
                ->addColumn('image', function ($data) {
                    $image = $data->image ? asset($data->image) : asset('images/default.png');
                    return '<img src="' . $image . '" width="35" alt="Social Media Image"/>';
                })

                ->editColumn('status', function ($data) {
                    return '<div class="form-check form-switch mb-2"><input type="checkbox" class="form-check-input"
                            onclick="changeStatus(event,' . $data->id . ')"
                            ' . ($data->status == "active" ? "checked" : "") . '></div>';
                })
                ->addColumn('action', function ($data) {
                    return '
                            <a href="' . route('dynamicpages.edit', $data->id) . '" class="btn btn-sm btn-primary">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <a href="' . route('dynamicpages.show', $data->id) . '" class="btn btn-sm btn-warning">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            <button type="button" onclick="showDeleteAlert(' . $data->id . ')" class="btn btn-sm btn-danger">
                                <i class="fa-regular fa-trash-can"></i>
                            </button>';
                })
                ->rawColumns(['bulk_check', 'status', 'image','action'])
                ->make(true);
        }
        return view('backend.layout.setting.dynamic_page.index');
    }

    public function create()
    {

        return view('backend.layout.setting.dynamic_page.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'page_title'   => 'required|max:255|string',
            'page_content' => 'required',
            'image' => 'required|image|mimes:jpeg,jpg,png,gif,svg|max:5120',
        ]);

        try {
            $page = new DynamicPage();
            $page->page_title = $request->page_title;
            $page->page_content = $request->page_content;
            $page->page_slug = Str::slug($request->page_title);
            $page->status = 'active';

            if ($request->hasFile('image')) {
                $imagePath = Helper::fileUpload($request->file('image'), 'DynamicPage', time() . '_' . $request->file('image')->getClientOriginalName());
                if ($imagePath !== null) {
                    $page->image = $imagePath;
                }
            }
            $page->save();

            flash()->success('Page created successfully.');
            return redirect()->route('dynamicpages.index');
        } catch (\Exception $e) {
            flash()->error('Something went wrong! Please try again.');
            return redirect()->back()->withInput();
        }
    }

    public function edit(string $id)
    {
        $data = DynamicPage::findOrFail($id);
        return view('backend.layout.setting.dynamic_page.edit', compact('data'));
    }

    public function update(Request $request, string $id)
    {

        $request->validate([

            'page_title' => 'required|max:255|string',
            'page_content' => 'required',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,gif,svg|max:5120',

        ]);

        $page = DynamicPage::findOrFail($id);
        $page->page_title = $request->page_title;
        $page->page_content = $request->page_content;
        $page->page_slug = Str::slug($request->page_title);
        $page->status = 'active';

        if ($request->hasFile('image')) {
            if ($page->image !== null) {
                Helper::fileDelete(public_path($page->image));
            }
            $imagePath = Helper::fileUpload($request->file('image'), 'DynamicPage', time() . '_' . $request->file('image')->getClientOriginalName());
            if ($imagePath !== null) {
                $page->image = $imagePath;
            }
        }

        $page->save();

        flash()->success('page updated successfully');
        return redirect()->route('dynamicpages.index');
    }

    public function destroy(string $id)
    {
        try {
            $page = DynamicPage::findOrFail($id);
            $page->delete();
            flash()->success('page deleted successfully');
            return response()->json([

                'success' => true,
                "message" => "Page deleted successfully."

            ]);
        } catch (\Exception $e) {
            return response()->json([

                'error' => true,
                "message" => "Failed to delete page."

            ]);
        }
    }

    public function changeStatus($id)
    {
        $data = DynamicPage::find($id);
        if (empty($data)) {
            return response()->json([
                "success" => false,
                "message" => "Item not found."
            ], 404);
        }


        // Toggle status
        if ($data->status == 'active') {
            $data->status = 'inactive';
            $data->save();

            return response()->json([
                'success' => false,
                'message' => 'Unpublished Successfully.',
                'data' => $data,
            ]);
        } else {
            $data->status = 'active';
            $data->save();

            return response()->json([
                'success' => true,
                'message' => 'Published Successfully.',
                'data' => $data,
            ]);
        }
        $page->save();
        return response()->json([
            'success' => true,
            'message' => 'Item status changed successfully.'
        ]);
    }


    public function bulkDelete(Request $request)
    {
        if ($request->ajax()) {
            $result = DynamicPage::whereIn('id', $request->ids)->get();

            if ($result) {
                DynamicPage::destroy($request->ids);
                return response()->json([
                    'success' => true,
                    'message' => 'Pages deleted successfully',
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Pages not found',
                ]);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong',
            ]);
        }
    }

    /*
    * Remove the specified resource from storage.
    * @param  int  $id
    * @return \Illuminate\Http\RedirectResponse
    */
    public function show($id)
    {
        $data = DynamicPage::findOrFail($id);
       return view('backend.layout.setting.dynamic_page.show', compact('data'));
    }
}
