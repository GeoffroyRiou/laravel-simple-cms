<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\File;

class BlocksService
{

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
     * Load blocks from package and custom namespaces.
     */
    public function getAllBlocks(): array
    {
        $blocks = [];

        // Package blocks
        $blocksPath = dirname(__DIR__) . '/Blocks';
        $blocks = array_merge($blocks, $this->loadBlocksFromPath($blocksPath));


        // Custom namespaces blocks
        $customNamespaces = config('simple-cms.blocks');
        foreach ($customNamespaces as $namespace) {
            $files = $this->getFilesByNamespace($namespace);
            $blocks = array_merge($blocks, $this->loadBlocksFromFiles($files, $namespace));
        }

        return $blocks;
    }

    /**
     * Load blocks from a given path.
     * @param string $path
     * @return array
     */
    protected function loadBlocksFromPath(string $path): array
    {
        $blocks = [];
        foreach (glob("{$path}/*.php") as $file) {
            $className = 'GeoffroyRiou\\NrCms\\Blocks\\' . basename($file, '.php');
            $blocks[] = $className::make();
        }
        return $blocks;
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
