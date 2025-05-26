<?php

namespace App\Filament\Fields;

use App\Models\Media;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\Field;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Set;
use Livewire\Attributes\On;

class MediaField extends Field
{
    protected string $view = 'forms.components.media-field';

    public bool $imagesOnly = false;

    public bool $filesOnly = false;

    protected function setUp(): void
    {
        parent::setUp();

        $this->registerActions([
            fn (self $component): Action => $component->getPickerAction(),
            fn (self $component): Action => $component->getUploadAction(),
        ]);
    }

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

    public function getPickerAction(): Action
    {
        return Action::make('picker')
            ->label(__('Select a Media File'))
            ->icon('heroicon-o-photo')
            ->form([
                MediaFilePickerField::make('media')
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
            ->label('Téléverser un fichier')
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

                $newMedia = Media::create([
                    'name' => $data['name'],
                    'path' => $data['path'],
                ]);

                $set(
                    $component->getStatePath(false),
                    $newMedia->path
                );
            });
    }

    public function getMediaFiles(): array
    {
        $state = $this->getState();
        if (is_array($state)) {
            return array_values($state);
        }elseif (is_string($state)) {
            return [$state];
        }
        return [];
    }
}
