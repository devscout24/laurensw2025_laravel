<?php

namespace App\Http\Controllers\Web\backend\tazim;

use App\Http\Controllers\Controller;
use App\Models\OurMission;
use Illuminate\Http\Request;

class MissionController extends Controller
{
    public function create()
    {
        $data = OurMission::whereId(1)->first();
        return view('backend.layout.tazim.mission.create', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'header'      => 'required|min:3',
            'title'       => 'required',
            'description' => 'required',
            'image_1'     => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'image_2'     => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        // Try to find the record with ID = 1
        $data = OurMission::find(1);

        if (! $data) {
            $data     = new OurMission();
            $data->id = 1; // Force ID 1 on first insert
        }

        $data->header      = $request->header;
        $data->title       = $request->title;
        $data->description = $request->description;

        // Handle image 1
        if ($request->hasFile('image_1')) {

            if (! empty($data->image_1) && file_exists(public_path($data->image_1))) {
                unlink(public_path($data->image_1));
            }

            $file1     = $request->file('image_1');
            $filename1 = time() . '_1.' . $file1->getClientOriginalExtension();
            $file1->move(public_path('backend/images/mission'), $filename1);
            $data->image_1 = 'backend/images/mission/' . $filename1;
        }

        // Handle image 2
        if ($request->hasFile('image_2')) {

            if (! empty($data->image_2) && file_exists(public_path($data->image_2))) {
                unlink(public_path($data->image_2));
            }

            $file2     = $request->file('image_2');
            $filename2 = time() . '_2.' . $file2->getClientOriginalExtension();
            $file2->move(public_path('backend/images/mission'), $filename2);
            $data->image_2 = 'backend/images/mission/' . $filename2;
        }

        $data->save(); // Always save (insert or update)

        return redirect()->route('mission.create')->with('success', 'Data Saved/Updated Successfully');
    }

    // public function store(Request $request)
    // {
    //     Log::info('image_1 file', ['file' => $request->file('image_1')]);
    //     Log::info('image_2 file', ['file' => $request->file('image_2')]);

    //     $request->validate([
    //         'header'      => 'required|min:3',
    //         'title'       => 'required',
    //         'description' => 'required',
    //         'image_1'     => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
    //         'image_2'     => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
    //     ]);

    //     $data = OurMission::firstOrNew(['id' => 1]);

    //     $data->header      = $request->header;
    //     $data->title       = $request->title;
    //     $data->description = $request->description;

    //     // if ($request->hasFile('image_1')) {
    //     //     $data->image_1 = $this->uploadAndReplace($request->file('image_1'), $data->image_1 ?? null, 'mission');
    //     // }

    //     // if ($request->hasFile('image_2')) {
    //     //     $data->image_2 = $this->uploadAndReplace($request->file('image_2'), $data->image_2 ?? null, 'mission');
    //     // }

    //     if ($request->image_1 != null) {
    //         if (file_exists($data->image_1)) {
    //             unlink($data->image_1);
    //         }
    //         $path            = $this->fileUpload($request->image_1, 'mission');
    //         $data['image_1'] = $path;
    //     }

    //     if ($request->image_2 != null) {
    //         if (file_exists($data->image_2)) {
    //             unlink($data->image_2);
    //         }
    //         $path            = $this->fileUpload($request->image_2, 'mission');
    //         $data['image_2'] = $path;
    //     }

    //     // if ($request->hasFile('image_1')) {
    //     //     if (file_exists($data->image_1) && $data->image_1 != 'default.jpg') {
    //     //         unlink($data->image_1);
    //     //     }
    //     //     $data['image_1'] = Helper::fileUpload($request->image_1, 'mission', $request->name . "-" . time());
    //     // }

    //     // if ($request->hasFile('image_2')) {
    //     //     if (file_exists($data->image_2) && $data->image_2 != 'default.jpg') {
    //     //         unlink($data->image_2);
    //     //     }
    //     //     $data['image_2'] = Helper::fileUpload($request->image_2, 'mission', $request->name . "-" . time());
    //     // }

    //     $data->save();

    //     return redirect()->back()->with('success', 'Data Updated Successfully');
    // }

    // protected function uploadAndReplace($file, $oldPath, $folder)
    // {
    //     if ($file) {
    //         Log::info('uploadAndReplace: file received', ['original' => $file->getClientOriginalName()]);

    //         if (! empty($oldPath) && file_exists(public_path($oldPath))) {
    //             unlink(public_path($oldPath));
    //         }

    //         return Controller::fileUpload($file, $folder);
    //     }

    //     return $oldPath;
    // }

    // protected function uploadAndReplace($file, $oldPath, $folder)
    // {
    //     if ($file) {
    //         if (! empty($oldPath) && file_exists(public_path($oldPath))) {
    //             unlink(public_path($oldPath));
    //         }

    //         return Controller::fileUpload($file, $folder);
    //     }

    //     return $oldPath;
    // }

}
