<?php
namespace App\Http\Controllers\Web\backend\tazim;

use App\Http\Controllers\Controller;
use App\Models\TermsConditionBanner;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class TermsConditionBannerController extends Controller
{
    public function create()
    {
        $data = TermsConditionBanner::whereId(1)->first();
        return view('backend.layout.tazim.termsCondition.create', compact('data'));
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'header'  => 'required|max:100',
                'title'   => 'required|max:500',
                'image'   => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,webp|max:7000',
                'alt_tag' => 'nullable|max:100',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors()->first())->withInput();
            }

            $data = TermsConditionBanner::find(1);

            if (! $data) {
                $data     = new TermsConditionBanner();
                $data->id = 1;
            }

            $data->header = $request->header;
            $data->title  = $request->title;
            $data->alt_tag = $request->alt_tag;

            if ($request->hasFile('image')) {
                if (! empty($data->image) && file_exists(public_path($data->image))) {
                    unlink(public_path($data->image));
                }

                $file     = $request->file('image');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $path     = public_path('backend/images/termsCondition');

                if (! file_exists($path)) {
                    mkdir($path, 0777, true);
                }

                if (! is_writable($path)) {
                    throw new \Exception("Directory not writable: " . $path);
                }

                $file->move($path, $filename);
                $data->image = 'backend/images/termsCondition/' . $filename;
            }

            $data->save();

            return redirect()->route('termsConditionBan.create')->with('success', 'Created Successfully');
        } catch (Exception $e) {
            Log::error('Data store failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'input' => $request->all(),
            ]);
            return redirect()->back()->with('error', 'Something went wrong while saving data.')->withInput();
        }
    }
}
