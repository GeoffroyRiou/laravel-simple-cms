<?php

namespace App\Livewire;

use App\Models\Media;
use App\Services\ImageService;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class MediaGallery extends Component
{
    use WithPagination, WithoutUrlPagination;

    public array $selectedPaths = [];
    public ?Collection $previewPaths = null;
    public bool $isMultiple = false;

    public string $modalUploadId = 'media-upload-modal';
    public string $modalPickerId = 'media-picker-modal';

    #[On('filament.locale-changed')] 
    public function resetComponent(): void
    {
        dd("here");
        $this->reset('page');
        $this->setPreviewPaths($this->selectedPaths);
    }

    public function mount(array $selectedPaths = [], bool $isMultiple = false): void
    {
        $this->isMultiple = $isMultiple;
        $this->selectedPaths = array_values($selectedPaths);
        $this->setPreviewPaths($this->selectedPaths);
    }

    private function setPreviewPaths(array $paths): void
    {
        $this->previewPaths = collect($paths);
    }

    public function isSelected(string $path): bool
    {
        return in_array($path, $this->selectedPaths);
    }

    public function getMediaFiles(): LengthAwarePaginator
    {
        $medias = Media::paginate(3);

        return $medias;
    }

    public function handleMediaClick(string $path): void
    {
        if (!$this->isMultiple) {
            $this->selectedPaths = [$path];
        } else {
            if (in_array($path, $this->selectedPaths)) {
                $this->selectedPaths = array_diff($this->selectedPaths, [$path]);
            } else {
                $this->selectedPaths[] = $path;
            }
        }

        $this->setPreviewPaths($this->selectedPaths);
        $this->dispatch('pathSelected', paths: $this->selectedPaths);
    }

    public function getFormattedMedias(Collection $paths): array
    {
        $service = app(ImageService::class);

        $formattedMedias = [];

        foreach ($paths as $path) {

            $mediaData = [
                'path' => $path,
                'isResizable' => $service->isResizable($path),
                'isSelected' => $this->isSelected($path),
            ];

            if ($service->isResizable($path)) {
                $mediaData['url'] = $service->imageUrl($path, 100, 100, true);
            }

            $formattedMedias[] = $mediaData;
        }

        return $formattedMedias;
    }

    public function confirm()
    {
        $this->dispatch('close-modal', id: $this->modalUploadId);
        $this->dispatch('close-modal', id: $this->modalPickerId);
    }


    public function render()
    {
        return view(
            'livewire.media-gallery',
            [
                'medias' => $this->getMediaFiles(),
                'previews' => $this->getFormattedMedias($this->previewPaths),
            ]
        );
    }
}
