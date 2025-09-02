<?php
namespace App\Http\Controllers\Web\backend\tazim;

use App\Http\Controllers\Controller;
use App\Models\GetInTouch;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class GetInTouchController extends Controller
{
    public function index()
    {
        $data = GetInTouch::where('id', 'asc')->get();
        return view('backend.layout.tazim.getintouch.index', compact('data'));
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $data = GetInTouch::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('message', function ($row) {
                    return Str::words(strip_tags($row->message), 8, '...');
                })
                ->addColumn('action', function ($data) {
                    return '
                            <a class="btn btn-sm btn-info" href="' . route('getInTouch.show', ['id' => $data->id]) . '">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                            <button type="button"  onclick="deleteData(\'' . route('getInTouch.delete', $data->id) . '\')" class="btn btn-danger del">
                                <i class="mdi mdi-delete"></i>
                            </button>';
                })
                ->setRowAttr([
                    'data-id' => function ($data) {
                        return $data->id;
                    },
                ])
                ->rawColumns(['message', 'action'])
                ->make(true);
        }

    }

    public function show($id)
    {
        $data = GetInTouch::find($id);
        return view('backend.layout.tazim.getintouch.show', compact('data'));
    }

    public function delete($id)
    {
        $delete = GetInTouch::find($id)->delete();
        if ($delete) {
            return back()->with('success', 'Deleted Successfully');
        } else {
            return back()->with('error', 'Try Again!');
        }
    }
}
