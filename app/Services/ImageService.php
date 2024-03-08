<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageService
{
        private const string BYTE_SCALE_API = 'https://api.bytescale.com/v2/accounts/';

    public function saveImage(UploadedFile $image):? string
    {
        $body = file_get_contents($image->getPathName());
        $apiKey = config('services.bytescale.api_key');
        $accountId = config('services.bytescale.account_id');
        $url = self::BYTE_SCALE_API . $accountId . '/uploads/binary';

        $response = Http::withBody($body, 'image/jpeg')
            ->withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
            ])
            ->post($url);

        return $response->json('fileUrl');
    }
}
