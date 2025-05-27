<?php

namespace App\Filament\Fields;

use App\Models\Media;
use Filament\Forms\Components\Field;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\On;

class MediaFilePickerField extends Field
{
    protected string $view = 'forms.components.media-file-picker-field';

    public bool $imagesOnly = false;

    public bool $filesOnly = false;

    public bool $multiple = false;

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

    public function isMultiple(): bool
    {
        return $this->multiple;
    }

    public function select(string $path): void
    {
        $state = $this->getState();

        if (!$this->multiple) {
            $this->setState([$path]);
        } else {
            if (in_array($path, $state)) {
                $this->setState(array_diff($state, [$path]));
            } else {
                $this->setState([
                    ...$state,
                    $path
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
