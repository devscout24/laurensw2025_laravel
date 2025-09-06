<?php
namespace App\Http\Controllers\Web\backend\tazim;

use App\Http\Controllers\Controller;
use App\Models\HomeBanner;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class HomeBannerController extends Controller
{
    public function create()
    {
        $data = HomeBanner::whereId(1)->first();
        return view('backend.layout.tazim.homeBanner.create', compact('data'));
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'header'                => 'required|max:100',
                'title'                 => 'required|max:500',
                'image'                 => 'required|file|mimes:jpeg,png,jpg,gif,svg,webp|max:7000',
                'experience'            => 'required|integer',
                'happy_travelers'       => 'required|integer',
                'number_of_destination' => 'required|integer',
                'alt_tag'               => 'nullable|max:100',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors()->first())->withInput();
            }

            $data = HomeBanner::find(1);

            if (! $data) {
                $data     = new HomeBanner();
                $data->id = 1;
            }

            $data->header                = $request->header;
            $data->title                 = $request->title;
            $data->experience            = $request->experience;
            $data->happy_travelers       = $request->happy_travelers;
            $data->number_of_destination = $request->number_of_destination;
            $data->alt_tag               = $request->alt_tag;

            if ($request->hasFile('image')) {
                if (! empty($data->image) && file_exists(public_path($data->image))) {
                    unlink(public_path($data->image));
                }

                $file     = $request->file('image');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $path     = public_path('backend/images/homeBanner');

                if (! file_exists($path)) {
                    mkdir($path, 0777, true);
                }

                if (! is_writable($path)) {
                    throw new \Exception("Directory not writable: " . $path);
                }

                $file->move($path, $filename);
                $data->image = 'backend/images/homeBanner/' . $filename;
            }

            $data->save();

            return redirect()->route('homeBanner.create')->with('success', 'Created Successfully');
        } catch (Exception $e) {
            Log::error('HomeBanner store failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'input' => $request->all(),
            ]);
            return redirect()->back()->with('error', 'Something went wrong while saving Home Banner.')->withInput();
        }
    }

    // public function store(Request $request)
    // {
    //     try {
    //         $validator = Validator::make($request->all(), [
    //             'header'                => 'required|max:100',
    //             'title'                 => 'required|max:500',
    //             'image'                 => 'required|file|mimes:jpeg,png,jpg,gif,svg,webp|max:7000',
    //             'experience'            => 'required|integer',
    //             'happy_travelers'       => 'required|integer',
    //             'number_of_destination' => 'required|integer',
    //             'alt_tag'               => 'nullable|max:100',
    //         ]);

    //         if ($validator->fails()) {
    //             return redirect()->back()->with('error', $validator->errors()->first())->withInput();
    //         }

    //         // ✅ Handle file first
    //         $imagePath = null;
    //         if ($request->hasFile('image')) {
    //             $file     = $request->file('image');
    //             $filename = time() . '.' . $file->getClientOriginalExtension();
    //             $path     = public_path('backend/images/homeBanner');

    //             if (! file_exists($path)) {
    //                 mkdir($path, 0777, true);
    //             }

    //             if (! is_writable($path)) {
    //                 throw new \Exception("Directory not writable: " . $path);
    //             }

    //             $file->move($path, $filename);
    //             $imagePath = 'backend/images/homeBanner/' . $filename;
    //         }

    //         // ✅ Use updateOrCreate
    //         $data = HomeBanner::updateOrCreate(
    //             ['id' => 1], // condition
    //             [
    //                 'header'                => $request->header,
    //                 'title'                 => $request->title,
    //                 'experience'            => $request->experience,
    //                 'happy_travelers'       => $request->happy_travelers,
    //                 'number_of_destination' => $request->number_of_destination,
    //                 'alt_tag'               => $request->alt_tag,
    //                 'image'                 => $imagePath, // overwrite only if new image uploaded
    //             ]
    //         );

    //         return redirect()->route('homeBanner.create')->with('success', 'Created/Updated Successfully');
    //     } catch (Exception $e) {
    //         dd($e->getMessage());
    //         Log::error('HomeBanner store failed: ' . $e->getMessage(), [
    //             'trace' => $e->getTraceAsString(),
    //             'input' => $request->all(),
    //         ]);
    //         return redirect()->back()->with('error', 'Something went wrong while saving Home Banner.')->withInput();
    //     }
    // }

}
