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
        $currentClass = $className;
        while ($currentClass !== false) {
            if ($currentClass === $parentClassName) {
                return true;
            }
            $currentClass = get_parent_class($currentClass);
        }

        return false;
    }

    /**
     * Check if the class uses a specific trait
     */
    public function usesTrait(string $className, string $traitName): bool
    {
        // Check if the current class uses the trait
        if (in_array($traitName, class_uses($className))) {
            return true;
        }

        // Check if the parent class uses the trait
        $parentClass = get_parent_class($className);
        return $parentClass && in_array($traitName, class_uses($parentClass));
    }

    /**
     * Check if the class is instantiable
     */
    public function isClassInstantiable($className): bool
    {
        // Create a reflection class for the given class name
        $reflection = new ReflectionClass($className);
        // Check if the class is instantiable
        return $reflection->isInstantiable();
    }

    /**
     * Get model classes from a specific path
     */
    public function getModelClassesFromPaths(array $modelsPaths): array
    {
        $modelClasses = [];

        foreach ($modelsPaths as $modelsPath) {

            foreach (glob($modelsPath.'/*.php') as $file) {
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
        return $this->extractNamespace($filePath).'\\'.basename($filePath, '.php');
    }
}
