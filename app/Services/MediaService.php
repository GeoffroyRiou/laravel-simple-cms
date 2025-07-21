<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Media;
use Illuminate\Support\Facades\Storage;

class MediaService
{
    /**
     * Retourne l'url d'un media
     *
     * @param  string  $path  Le chemin de l'image
     **/
    public function getMediaUrl(string $path, string $disk = 'public'): string
    {
        return Storage::disk($disk)->url($path);
    }

    public function saveUploadedMediasFromFileUploadField(array $data): array
    {

        $mediasPath = [];

        if (empty($data['path']))
            return $mediasPath;

        if(!is_array($data['path'])){
            $data['path'] = [$data['path']];
            $data['attachment_file_names'] = [$data['attachment_file_names']];
        }

        foreach ($data['path'] as $path) {
            Media::create([
                'path' => $path,
                'name' => !empty($data['attachment_file_names'][$path]) ? $data['attachment_file_names'][$path] : $path
            ]);

            $mediasPath[] = $path;
        }

        return $mediasPath;
    }
}
