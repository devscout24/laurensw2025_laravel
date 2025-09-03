<?php

namespace App\Http\Controllers\Web\backend;

use App\Http\Controllers\Controller;
use App\Models\Socialmedia;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class SocialMediaController extends Controller
{
    /**
     * Display a listing of Question content.
     *
     * @param Request $request
     * @return View|JsonResponse
     * @throws Exception
     */
    public function index(Request $request): View | JsonResponse
    {
        if ($request->ajax()) {
            $query = Socialmedia::query(); // Query builder instance
            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('image', function ($data) {
                    $image = $data->image ? asset($data->image) : asset('images/default.png');
                    return '<img src="' . $image . '" width="35" alt="">';
                })
                ->addColumn('url', function ($data) {
                    return $data->url ?? 'N/A';
                })
                ->addColumn('status', function ($data) {
                    $backgroundColor  = $data->status == "active" ? '#4CAF50' : '#ccc';
                    $sliderTranslateX = $data->status == "active" ? '26px' : '2px';
                    $sliderStyles     = "position: absolute; top: 2px; left: 2px; width: 20px; height: 20px; background-color: white; border-radius: 50%; transition: transform 0.3s ease; transform: translateX($sliderTranslateX);";

                    $status = '<div class="form-check form-switch" style="margin-left:40px; position: relative; width: 50px; height: 24px; background-color: ' . $backgroundColor . '; border-radius: 12px; transition: background-color 0.3s ease; cursor: pointer;">';
                    $status .= '<input onclick="showStatusChangeAlert(' . $data->id . ')" type="checkbox" class="form-check-input" id="customSwitch' . $data->id . '" getAreaid="' . $data->id . '" name="status" style="position: absolute; width: 100%; height: 100%; opacity: 0; z-index: 2; cursor: pointer;">';
                    $status .= '<span style="' . $sliderStyles . '"></span>';
                    $status .= '<label for="customSwitch' . $data->id . '" class="form-check-label" style="margin-left: 10px;"></label>';
                    $status .= '</div>';

                    return $status;
                })
                ->addColumn('action', function ($data) {
                    return '<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                        <a href="' . route('social.media.edit', $data->id) . '" class="btn btn-primary fs-14 text-white edit-icn" title="Edit"><i class="fe fe-edit"></i></a>
                        <a href="#" onclick="showDeleteConfirm(' . $data->id . ')" class="btn btn-danger fs-14 text-white delete-icn" title="Delete"><i class="fe fe-trash"></i></a>
                    </div>';
                })
                ->rawColumns(['image', 'url', 'status', 'action'])
                ->make(true); // make(true)
        }
        return view('backend.layout.social-media.index');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create(): View
    {
        return view('backend.layouts.question.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'title'    => 'required|string|max:255',
                'question' => 'required|string|max:1000',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $data = new Socialmedia();
            $data->title = $request->title;
            $data->question = $request->question;
            $data->save();

            return redirect()->route('question.index')->with('t-success', 'Created Successfully.');
        } catch (Exception $e) {
            return redirect()->back()->with('t-error', 'Something went wrong!');
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $data = Socialmedia::findOrFail($id);
        return view('backend.layouts.question.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'title'    => 'required|string|max:255',
                'question' => 'required|string|max:1000',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $data = Socialmedia::findOrFail($id);
            $data->title = $request->title;
            $data->question = $request->question;
            $data->save();

            return redirect()->route('question.index')->with('t-success', 'Updated Successfully.');
        } catch (Exception $e) {
            // dd($e);
            return redirect()->back()->with('t-error', 'Something went wrong!');
        }
    }

    /**
     * Update the status of the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function status(int $id): JsonResponse
    {
        $data = Socialmedia::findOrFail($id);
        if ($data->status == 'active') {
            $data->status = 'inactive';
            $data->save();

            return response()->json([
                'success' => false,
                'message' => 'Unpublished Successfully.',
                'data'    => $data,
            ]);
        } else {
            $data->status = 'active';
            $data->save();

            return response()->json([
                'success' => true,
                'message' => 'Published Successfully.',
                'data'    => $data,
            ]);
        }
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
            $data = Socialmedia::findOrFail($id);
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
