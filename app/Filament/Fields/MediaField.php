<?php

namespace App\Filament\Fields;

use App\Filament\Schemas\MediaSchema;
use App\Models\Media;
use App\Services\MediaService;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\Field;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Set;
use Filament\Support\Enums\ActionSize;
use Livewire\Attributes\On;

class MediaField extends Field
{
    protected string $view = 'forms.components.media-field';

    public bool $imagesOnly = false;

    public bool $filesOnly = false;

    public bool $multiple = false;

    public bool $showPicker = true;

    public bool $showUpload = true;

    public int $max = 0;

    protected function setUp(): void
    {
        parent::setUp();

        $this->registerActions([
            fn(self $component): Action => $component->getPickerAction(),
            fn(self $component): Action => $component->getUploadAction(),
        ]);
    }

    public function imagesOnly(bool $imagesOnly = true): self
    {
        $this->imagesOnly = $imagesOnly;

        return $this;
    }

    public function multiple(bool $multiple = true): self
    {
        $this->multiple = $multiple;

        return $this;
    }

    public function filesOnly(bool $filesOnly = true): self
    {
        $this->filesOnly = $filesOnly;

        return $this;
    }

    public function max(int $max = 0): self
    {
        $this->max = $max;

        return $this;
    }

    public function showPicker(bool $show = true): self
    {
        $this->showPicker = $show;

        return $this;
    }

    public function showUpload(bool $show = true): self
    {
        $this->showUpload = $show;

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

    public function getShowPicker(): bool
    {
        return $this->showPicker;
    }

    public function getShowUpload(): bool
    {
        return $this->showUpload;
    }

    public function getPickerAction(): Action
    {
        return Action::make('picker')
            ->label(__('Select a media file'))
            ->icon('heroicon-o-photo')
            ->form([
                MediaFilePickerField::make('media')
                    ->label('')
                    ->multiple($this->multiple)
                    ->max($this->max)
                    ->imagesOnly($this->imagesOnly)
                    ->filesOnly($this->filesOnly),
            ])
            ->fillForm(fn(Component $component): array => [
                'media' => $component->getState(),
            ])
            ->action(function (array $data, Set $set, Component $component) {
                $set(
                    $component->getStatePath(false),
                    $data['media']
                );
            })
            ->size(ActionSize::Small);
    }

    public function getUploadAction(): Action
    {
        return Action::make('upload')
            ->label(__('Upload a media file'))
            ->icon('heroicon-o-arrow-up-on-square')
            ->form(
                MediaSchema::make(
                    fieldName: 'path',
                    label: 'Médias',
                    multiple: $this->multiple,
                    imagesOnly: $this->imagesOnly,
                    filesOnly: $this->filesOnly,
                    max: $this->max,
                ) 
            )
            ->action(function (array $data, Set $set, Component $component) {

                $mediaService = app(MediaService::class);

                $mediasPath = $mediaService->saveUploadedMediasFromFileUploadField($data);

                $state = $this->getState() ?? [];
                $newState = $this->multiple ? [...$state, ...$mediasPath] : $mediasPath[0]->path;

                $set(
                    $component->getStatePath(false),
                    $newState
                );
            })
            ->size(ActionSize::Small);
    }

    public function getMediaFiles(): array
    {
        $state = $this->getState() ?? [];

        if (is_array($state)) {
            $state = array_values($state);
        } elseif (is_string($state)) {
            $state = [$state];
        }

        // TODO : Extract this query in an action
        $medias = Media::all();

        $state = array_map(function (string $item) use ($medias) {
            return $medias->filter(fn($media) => false !== stripos($media->path, $item))->first();
        }, $state);

        $state = array_filter($state, function ($item) {
            return $item instanceof Media;
        });


        return $state ?? [];
    }
}
