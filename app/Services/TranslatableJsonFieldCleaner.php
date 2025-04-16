<?php

declare(strict_types=1);

namespace App\Services;

class TranslatableJsonFieldCleaner
{
    /**
     * Clean the JSON by transforming specific image structures.
     *
     * @param array $data The JSON data as an associative array.
     * @return array The cleaned JSON data.
     */
    public function clean(array $data): array
    {
        return $this->recursiveClean($data);
    }

    /**
     * Recursively clean the JSON data.
     *
     * @param array $data The JSON data as an associative array.
     * @return array The cleaned JSON data.
     */
    private function recursiveClean(array $data): array
    {
        $cleanedData = [];

        foreach ($data as $key => $value) {
            
            if (is_array($value)) {
                $cleanedData[$key] = $this->recursiveClean($value);
            } elseif (is_string($value) && is_string($key) && $this->isImageKey($key) && $this->isImage($value)) {
                $cleanedData[$key] = [$value];
            }else{
                $cleanedData[$key] = $value;}
        }

        return $cleanedData;
    }

    private function isImage($string) {
        $imageExtensions = array('.jpg', '.jpeg', '.png', '.gif', '.bmp', '.svg');
        $string = strtolower($string);
        foreach ($imageExtensions as $extension) {
            if (substr($string, -strlen($extension)) === $extension) {
                return true;
            }
        }
        return false;
    }

    private function isImageKey(string $string) {
        $imageWords = array('image','illustration','picture');
        $string = strtolower($string);
        foreach ($imageWords as $word) {
            if (strpos($string, $word) !== false) {
                return true;
            }
        }
        return false;
    }
}


