<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageService //bytescale.com
{
    public function saveImage(UploadedFile $image): string
    {
        $response = Http::withBody(
            file_get_contents($image->getPathName()), 'image/jpeg'
        )
            ->withHeaders([
            'Authorization' => 'Bearer '.config('services.bytescale.api_key'),
        ])
            ->post('https://api.bytescale.com/v2/accounts/'.config('services.bytescale.account_id').'/uploads/binary');

        return $response->json('fileUrl');
    }
}
