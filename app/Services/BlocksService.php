<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\File;

class BlocksService
{

    /**
     * Load blocks from namespaces.
     */
    public function getAllBlocks(): array
    {
        $blocks = [];

        $customNamespaces = config('simple-cms.blocks');
        foreach ($customNamespaces as $namespace) {
            $files = $this->getFilesByNamespace($namespace);
            $blocks = array_merge($blocks, $this->loadBlocksFromFiles($files, $namespace));
        }

        return $blocks;
    }

    /**
     * Get all files in the specified namespace directory.
     *
     * @param string $namespace
     * @return array
     */
    public function getFilesByNamespace(string $namespace): array
    {
        // Convert namespace to path
        $path = app_path(str_replace(['\\', 'App'], ['/', ''], $namespace));

        // Check if the directory exists
        if (!File::exists($path)) {
            return [];
        }

        // Get all files in the directory
        return File::allFiles($path);
    }

    /**
     * Load blocks from an array of files.
     * @param array $files
     * @param string $namespace
     * @return array
     */
    protected function loadBlocksFromFiles(array $files, string $namespace): array
    {
        $blocks = [];
        foreach ($files as $file) {
            $className = $namespace . '\\' . basename($file->getFilename(), '.php');
            $blocks[] = $className::make();
        }
        return $blocks;
    }
}
