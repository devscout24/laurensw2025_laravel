<?php
namespace App\Http\Controllers\Web\backend\tazim;

use App\Http\Controllers\Controller;
use App\Models\GoogleSnippet;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class GoogleSnippetController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = GoogleSnippet::latest()->get();

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
                ->editColumn('snippet_content', function ($data) {
                    return Str::limit(strip_tags($data->snippet_content), 70);
                })

                ->editColumn('status', function ($data) {
                    return '<div class="form-check form-switch mb-2"><input type="checkbox" class="form-check-input"
                            onclick="changeStatus(event,' . $data->id . ')"
                            ' . ($data->status == "active" ? "checked" : "") . '></div>';
                })
                ->addColumn('action', function ($data) {
                    return '
                            <a href="' . route('snippet.edit', $data->id) . '" class="btn btn-sm btn-primary">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <a href="' . route('snippet.show', $data->id) . '" class="btn btn-sm btn-warning">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            <button type="button" onclick="showDeleteAlert(' . $data->id . ')" class="btn btn-sm btn-danger">
                                <i class="fa-regular fa-trash-can"></i>
                            </button>';
                })
                ->rawColumns(['bulk_check', 'status', 'action'])
                ->make(true);
        }
        return view('backend.layout.tazim.googleSnippet.index');
    }

    public function create()
    {

        return view('backend.layout.tazim.googleSnippet.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'           => 'required|max:255|string',
            'snippet_content' => 'required',
        ]);

        try {
            $snippet                  = new GoogleSnippet();
            $snippet->title           = $request->title;
            $snippet->snippet_content = $request->snippet_content;
            $snippet->slug            = Str::slug($request->title);
            $snippet->status          = 'active';

            $snippet->save();

            flash()->success('Snippet created successfully.');
            return redirect()->route('snippet.index');
        } catch (\Exception $e) {
            flash()->error('Something went wrong! Please try again.');
            return redirect()->back()->withInput();
        }
    }

    public function edit(string $id)
    {
        $data = GoogleSnippet::findOrFail($id);
        return view('backend.layout.tazim.googleSnippet.edit', compact('data'));
    }

    public function update(Request $request, string $id)
    {

        $request->validate([
            'title'           => 'required|max:255|string',
            'snippet_content' => 'required',

        ]);

        $snippet                  = GoogleSnippet::findOrFail($id);
        $snippet->title           = $request->title;
        $snippet->snippet_content = $request->snippet_content;
        $snippet->slug            = Str::slug($request->title);
        $snippet->status          = 'active';

        $snippet->save();

        flash()->success('Snippet updated successfully');
        return redirect()->route('snippet.index');
    }

    public function destroy(string $id)
    {
        try {
            $snippet = GoogleSnippet::findOrFail($id);
            $snippet->delete();
            flash()->success('Snippet deleted successfully');
            return response()->json([

                'success' => true,
                "message" => "Snippet deleted successfully.",

            ]);
        } catch (\Exception $e) {
            return response()->json([

                'error'   => true,
                "message" => "Failed to delete snippet.",

            ]);
        }
    }

    public function changeStatus($id)
    {
        $data = GoogleSnippet::find($id);
        if (empty($data)) {
            return response()->json([
                "success" => false,
                "message" => "Item not found.",
            ], 404);
        }

        // Toggle status
        if ($data->status == 'active') {
            $data->status = 'inactive';
            $data->save();

            return response()->json([
                'success' => false,
                'message' => 'Activated Successfully.',
                'data'    => $data,
            ]);
        } else {
            $data->status = 'active';
            $data->save();

            return response()->json([
                'success' => true,
                'message' => 'Activated Successfully.',
                'data'    => $data,
            ]);
        }
        $page->save();
        return response()->json([
            'success' => true,
            'message' => 'Item status changed successfully.',
        ]);
    }

    public function bulkDelete(Request $request)
    {
        if ($request->ajax()) {
            $result = GoogleSnippet::whereIn('id', $request->ids)->get();

            if ($result) {
                GoogleSnippet::destroy($request->ids);
                return response()->json([
                    'success' => true,
                    'message' => 'Snippet deleted successfully',
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Snippet not found',
                ]);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong',
            ]);
        }
    }

    public function show($id)
    {
        $data = GoogleSnippet::findOrFail($id);
        return view('backend.layout.tazim.googleSnippet.show', compact('data'));
    }
}
