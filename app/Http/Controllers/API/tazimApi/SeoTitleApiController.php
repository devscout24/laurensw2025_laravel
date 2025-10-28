<?php
namespace App\Http\Controllers\API\tazimApi;

use App\Http\Controllers\Controller;
use App\Models\SeoTitle;
use App\Traits\apiresponse;

class SeoTitleApiController extends Controller
{
    use apiresponse;
    public function index()
    {
        $data = SeoTitle::with('language') // eager load the related language
            ->select('id', 'title', 'description', 'lang_id')
            ->get()
            ->map(function ($item) {
                return [
                    'id'            => $item->id,
                    'title'         => $item->title,
                    'description'   => $item->description,
                    'lang_id'       => $item->lang_id,
                    'language_name' => $item->language->name ?? 'N/A', // get name from relation
                ];
            });

        return $this->success($data, 'Success', 200);
    }

    public function arcticCruise($lang_name)
    {
        $data = SeoTitle::whereHas('language', function ($query) use ($lang_name) {
            $query->where('name', $lang_name);
        })
            ->where(function ($q) {
                $q->where('title', 'Arctic Cruise')
                    ->orWhere('title', 'Arctic Cruise Dutch');
            })
            ->select('id', 'title', 'description', 'lang_id')
            ->with('language:id,name,code')
            ->first();

        if (! $data) {
            return response()->json([
                'success' => false,
                'message' => 'No record found for this language.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Success',
            'data'    => $data,
        ], 200);
    }

    public function expeditionAntarctica($lang_name)
    {
        $data = SeoTitle::whereHas('language', function ($query) use ($lang_name) {
            $query->where('name', $lang_name);
        })
            ->where(function ($q) {
                $q->where('title', 'Expedition Antarctica')
                    ->orWhere('title', 'Expedition Antarctica Dutch');
            })
            ->select('id', 'title', 'description', 'lang_id')
            ->with('language:id,name,code')
            ->first();

        if (! $data) {
            return response()->json([
                'success' => false,
                'message' => 'No record found for this language.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Success',
            'data'    => $data,
        ], 200);
    }

    public function cruiseSvalbard($lang_name)
    {
        $data = SeoTitle::whereHas('language', function ($query) use ($lang_name) {
            $query->where('name', $lang_name);
        })
            ->where(function ($q) {
                $q->where('title', 'Cruise Svalbard')
                    ->orWhere('title', 'Cruise Svalbard Dutch');
            })
            ->select('id', 'title', 'description', 'lang_id')
            ->with('language:id,name,code')
            ->first();

        if (! $data) {
            return response()->json([
                'success' => false,
                'message' => 'No record found for this language.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Success',
            'data'    => $data,
        ], 200);
    }

    public function cruiseGreenland($lang_name)
    {
        $data = SeoTitle::whereHas('language', function ($query) use ($lang_name) {
            $query->where('name', $lang_name);
        })
            ->where(function ($q) {
                $q->where('title', 'Cruise Greenland')
                    ->orWhere('title', 'Cruise Greenland Dutch');
            })
            ->select('id', 'title', 'description', 'lang_id')
            ->with('language:id,name,code')
            ->first();

        if (! $data) {
            return response()->json([
                'success' => false,
                'message' => 'No record found for this language.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Success',
            'data'    => $data,
        ], 200);
    }

}
