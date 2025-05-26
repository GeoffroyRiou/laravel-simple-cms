<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;

class ImageService
{
    private string $resizedDirectory = 'sizes';

    /**
     * Retourne l'url d'une image aux dimensions demandées
     *
     * @param  string  $path  Le chemin de l'image
     * @param  int  $width  La largeur de l'image
     * @param  int  $height  La hauteur de l'image
     * @param  bool  $crop  Indique si l'image doit être recadrée
     **/
    public function imageUrl(string|array $path, int $width = 100, int $height = 100, bool $crop = true, string $disk = 'public'): string
    {

        if (is_array($path)) {
            $path = count($path) ? array_values($path)[0] : '';
        }

        $storageUrl = Storage::disk($disk)->url($this->getResizedImage($path, $width, $height, $crop, $disk));

        if ($disk === 'private') {
            return str_replace('storage', 'espace-parents', $storageUrl);
        }

        return $storageUrl;
    }

    /**
     * Point d'entrée principal pour le redimensionnement d'image
     */
    public function getResizedImage(string $imagePath, int $width, int $height, bool $crop = true, string $disk = 'public'): string
    {
        if (! $this->isResizable($imagePath)) {
            return $imagePath;
        }

        $resizedFilename = $this->generateResizedFilename($imagePath, $width, $height, $crop);
        $resizedPath = $this->getResizedPath($resizedFilename);

        if (! $this->resizedImageExists($resizedPath, $disk)) {
            $this->createResizedImage($imagePath, $resizedPath, $width, $height, $crop, $disk);
        }

        return $this->getPublicPath($resizedFilename);
    }

    /**
     * Génère le nom du fichier redimensionné
     */
    private function generateResizedFilename(string $imagePath, int $width, int $height, bool $crop): string
    {
        $filename = basename($imagePath);

        return sprintf(
            '%s-%dx%d%s.webp',
            pathinfo($filename, PATHINFO_FILENAME),
            $width,
            $height,
            $crop ? '-crop' : ''
        );
    }

    /**
     * Retourne le chemin complet du fichier redimensionné
     */
    private function getResizedPath(string $resizedFilename): string
    {
        return $this->resizedDirectory.'/'.$resizedFilename;
    }

    /**
     * Retourne le chemin de l'image originale
     */
    private function getOriginalPath(string $imagePath, string $disk): string
    {
        return Storage::disk($disk)->path($imagePath);
    }

    /**
     * Vérifie si l'image redimensionnée existe déjà
     */
    private function resizedImageExists(string $resizedPath, string $disk): bool
    {
        return Storage::disk($disk)->exists($resizedPath);
    }

    /**
     * Crée l'image redimensionnée
     */
    private function createResizedImage(string $imagePath, string $resizedPath, int $width, int $height, bool $crop, string $disk): void
    {
        $manager = ImageManager::gd();
        $image = $manager->read($this->getOriginalPath($imagePath, $disk));

        if ($crop) {
            $image->cover($width, $height, position: 'center');
        } else {
            $image->scale($width);
        }

        Storage::disk($disk)->put($resizedPath, $image->toWebp(80)->toString());
    }

    /**
     * Retourne le chemin public de l'image redimensionnée
     */
    private function getPublicPath(string $resizedFilename): string
    {
        return $this->resizedDirectory.'/'.$resizedFilename;
    }

    /**
     * Vérifie si le format de l'image permet le redimensionnement
     */
    public function isResizable(string $filename): bool
    {
        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp', 'avif'];

        return in_array($extension, $allowedExtensions);
    }
}
