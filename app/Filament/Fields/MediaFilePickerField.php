<?php

namespace App\Filament\Fields;

use App\Models\Media;
use Filament\Forms\Components\Field;
use Illuminate\Database\Eloquent\Collection;

class MediaFilePickerField extends Field
{
    protected string $view = 'forms.components.media-file-picker-field';

    public bool $imagesOnly = false;

    public bool $filesOnly = false;

    public bool $multiple = false;

    public int $max = 0;

    public function imagesOnly(bool $imagesOnly = true): static
    {
        $this->imagesOnly = $imagesOnly;

        return $this;
    }

    public function filesOnly(bool $filesOnly = true): static
    {
        $this->filesOnly = $filesOnly;

        return $this;
    }

    public function multiple(bool $multiple = true): static
    {
        $this->multiple = $multiple;

        return $this;
    }

    public function max(int $max = 0): self
    {
        $this->max = $max;

        return $this;
    }

    public function isMultiple(): bool
    {
        return $this->multiple;
    }

    public function getMax(): int
    {
        return $this->max;
    }

    public function select(string $path): void
    {
        $state = $this->getState();

        if (! $this->multiple) {
            $this->state([$path]);
        } else {
            if (in_array($path, $state)) {
                $this->state(array_diff($state, [$path]));
            } else {
                $this->state([
                    ...$state,
                    $path,
                ]);
            }
        }
    }

    public function getMediaFiles(): Collection
    {

        $medias = Media::query();

        if ($this->imagesOnly) {
            $medias->where('type', 'image');
        } elseif ($this->filesOnly) {
            $medias->where('type', 'file');
        }

        return $medias->get();
    }
}
