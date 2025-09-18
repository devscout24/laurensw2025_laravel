<?php
namespace App\Http\Controllers\API\tazimApi;

use App\Http\Controllers\Controller;
use App\Traits\apiresponse;

class TranslateApiController extends Controller
{
    use apiresponse;
    // public function translate(Request $request)
    // {
    //     $request->validate([
    //         'text'   => 'required|string',
    //         'target' => 'required|string', // e.g. "es", "fr", "bn"
    //         'source' => 'nullable|string', // optional, defaults to auto
    //     ]);

    //     // Always fetch key from .env (or config/services.php)
    //     $apiKey = env('GOOGLE_TRANSLATE_KEY', config('services.google_translate.key'));

    //     if (empty($apiKey)) {
    //         return $this->error([], 'Google Translate API key not configured.', 500);
    //     }

    //     $text   = $request->text;
    //     $target = $request->target;
    //     $source = $request->source ?? 'auto';

    //     try {
    //         // Send request to Google Translate API
    //         $response = Http::get("https://translation.googleapis.com/language/translate/v2", [
    //             'q'      => $text,
    //             'target' => $target,
    //             'source' => $source,
    //             'format' => 'text',
    //             'key'    => $apiKey, // appended as query param
    //         ]);

    //         if ($response->failed()) {
    //             return $this->error($response->json(), 'Translation request failed', 500);
    //         }

    //         $data = $response->json();

    //         $result = [
    //             'translatedText' => $data['data']['translations'][0]['translatedText'] ?? null,
    //             'detectedSource' => $data['data']['translations'][0]['detectedSourceLanguage'] ?? $source,
    //         ];

    //         return $this->success($result, 'Success', 200);

    //     } catch (\Exception $e) {
    //         return $this->error([], 'Exception: ' . $e->getMessage(), 500);
    //     }
    // }

    public function translate()
    {
        try {
            $apiKey = env('GOOGLE_TRANSLATE_KEY', config('services.google_translate.key'));

            if (empty($apiKey)) {
                return $this->error([], 'Google Translate API key not configured.', 500);
            }

            // Just return the API key and the base URL
            return $this->success([
                'api_key'  => $apiKey,
                'base_url' => 'https://translation.googleapis.com/language/translate/v2',
            ], 'Success', 200);

        } catch (\Exception $e) {
            return $this->error([], 'Exception: ' . $e->getMessage(), 500);
        }
    }

}
