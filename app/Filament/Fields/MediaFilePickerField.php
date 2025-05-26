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

    public function imagesOnly(bool $imagesOnly = false): static
    {
        $this->imagesOnly = $imagesOnly;

        return $this;
    }

    public function filesOnly(bool $filesOnly = false): static
    {
        $this->filesOnly = $filesOnly;

        return $this;
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
