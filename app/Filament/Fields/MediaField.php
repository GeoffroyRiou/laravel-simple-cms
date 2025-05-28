<?php

namespace App\Filament\Fields;

use App\Models\Media;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\Field;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Set;

class MediaField extends Field
{
    protected string $view = 'forms.components.media-field';

    public bool $imagesOnly = false;

    public bool $filesOnly = false;

    public bool $multiple = false;

    protected function setUp(): void
    {
        parent::setUp();

        $this->registerActions([
            fn (self $component): Action => $component->getPickerAction(),
            fn (self $component): Action => $component->getUploadAction(),
        ]);
    }

    public function imagesOnly(bool $imagesOnly = true): static
    {
        $this->imagesOnly = $imagesOnly;

        return $this;
    }

    public function multiple(bool $multiple = true): static
    {
        $this->multiple = $multiple;

        return $this;
    }

    public function filesOnly(bool $filesOnly = true): static
    {
        $this->filesOnly = $filesOnly;

        return $this;
    }

    public function isMultiple(): bool
    {
        return $this->multiple;
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
                    ->imagesOnly($this->imagesOnly)
                    ->filesOnly($this->filesOnly),
            ])
            ->fillForm(fn (Component $component): array => [
                'media' => $component->getState(),
            ])
            ->action(function (array $data, Set $set, Component $component) {
                $set(
                    $component->getStatePath(false),
                    $data['media']
                );
            });
    }

    public function getUploadAction(): Action
    {
        return Action::make('upload')
            ->label(__('Upload a media file'))
            ->icon('heroicon-o-photo')
            ->form([
                FileUpload::make('path')
                    ->label('Media')
                    ->maxSize(5120)
                    ->columnSpanFull()
                    ->panelLayout(null)
                    ->afterStateUpdated(fn (Set $set, $state): mixed => $set('name', $state->getClientOriginalName()))
                    ->required()
                    ->panelLayout(null),
                TextInput::make('name')
                    ->label(__('Name'))
                    ->live(onBlur: true),
            ])
            ->action(function (array $data, Set $set, Component $component) {

                $newMedia = Media::create($data);

                $newState = $this->multiple ? [...$this->getState(), $newMedia->path] : $newMedia->path;

                $set(
                    $component->getStatePath(false),
                    $newState
                );
            });
    }

    public function getMediaFiles(): array
    {
        $state = $this->getState();
        if (is_array($state)) {
            $state = array_values($state);
        } elseif (is_string($state)) {
            $state = [$state];
        }

        // TODO : Extract this query in an action
        $medias = Media::all();

        $state = array_map(function (string $item) use ($medias) {
            $media = $medias->where('path', $item)->first();

            return $media;
        }, $state);

        return $state ?: [];
    }
}
