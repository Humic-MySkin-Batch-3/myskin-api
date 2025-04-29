<?php
namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;

class SkinAiService
{
    public static function predict(UploadedFile $image): ?float
    {
        $response = Http::timeout(5)
            ->withHeaders([
                'Accept' => 'application/json',
                // 'Authorization' => 'Bearer ' . config('ai.predict_key'),
            ])
            ->attach(
                'image',
                fopen($image->getRealPath(), 'r'),
                $image->getClientOriginalName()
            )
            ->post(config('ai.predict_url'));


        if (! $response->ok() || ! isset($response['prediction'])) {
            return null;
        }

        return (float) $response['prediction'];
    }
}
