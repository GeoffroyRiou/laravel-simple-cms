<?php

declare(strict_types=1);

namespace App\Services;

use ReflectionClass;

class ReflectionService
{
    /**
     * Extract namespace from a file path
     */
    public function extractNamespace(string $filePath): ?string
    {
        $content = file_get_contents($filePath);
        $pattern = '/namespace\s+([a-zA-Z_][a-zA-Z0-9_\\\\]*)\s*;/';

        if (preg_match($pattern, $content, $matches)) {
            return $matches[1];
        }

        return null;
    }

    /**
     * Check if the class inherit from a sepecific class
     */
    public function hasParentOfType(string $className, string $parentClassName): bool
    {
        // Create a reflection class for the model
        $reflection = new ReflectionClass($className);

        // Get the parent class of the model
        $parent = $reflection->getParentClass();

        // Check if the parent class is the one we are looking for
        while ($parent) {
            if ($parent->name === $parentClassName) {
                return true;
            }
            $parent = $parent->getParentClass();
        }

        return false;
    }

    /**
     * Check if the class uses a specific trait
     */
    public function usesTrait(string $className, string $traitName): bool
    {
        $reflection = new ReflectionClass($className);
        $traits = $reflection->getTraits();
        return array_key_exists($traitName, $traits);
    }

    /**
     * Check if the class is instantiable
     */
    function isClassInstantiable($className)
    {
        // Create a reflection class for the given class name
        $reflection = new ReflectionClass($className);

        // Check if the class is instantiable
        if ($reflection->isInstantiable()) {
            return true;
        }

        return false;
    }

    /**
     * Get model classes from a specific path
     */
    public function getModelClassesFromPaths(array $modelsPaths): array
    {
        $modelClasses = [];

        foreach ($modelsPaths as $modelsPath) {

            foreach (glob($modelsPath . '/*.php') as $file) {
                $className = $this->getClassNameFromFile($file);

                if (class_exists($className)) {
                    $modelClasses[] = $className;
                }
            }
        }

        return $modelClasses;
    }

    /**
     * Get the class name from a file path
     */
    public function getClassNameFromFile(string $filePath): string
    {
        return $this->extractNamespace($filePath) . '\\' . basename($filePath, '.php');
    }
}
