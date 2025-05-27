<div>
    @use('App\Facades\SimpleCmsImage')

    <div class="flex flex-col gap-8">
        <div class="flex flex-wrap gap-2">
            @foreach ($previews as $media)
                <div class="media-preview" wire:click.prevent="handleMediaClick('{{ $media['path'] }}')">
                    <x-filament::avatar src="{{ $media['isResizable'] ? $media['url'] : '' }}" :circular="false"
                        alt="" size="w-20 h-20" />
                    <p class="name">{{ $media['name'] ?? '' }}</p>
                    <div class="overlay">
                        <x-icon name="heroicon-o-trash" class="icon" />
                    </div>
                </div>
            @endforeach
        </div>

        <div>
            <x-filament::modal id="{{ $modalPickerId }}">
                <x-slot name="trigger">
                    <x-filament::button>
                        Uploader un média
                    </x-filament::button>
                </x-slot>

                <x-slot name="heading">
                    Uploader un nouveau media
                </x-slot>

                <div class="grid xl:grid-cols-4 gap-x-2">
                    Ici le champ d'upload
                </div>
            </x-filament::modal>


            <x-filament::modal id="{{ $modalPickerId }}" slide-over width="5xl">
                <x-slot name="trigger">
                    <x-filament::button>
                        Choisir un média
                    </x-filament::button>
                </x-slot>

                <x-slot name="heading">
                    Choisir un média existant
                </x-slot>

                <div class="media-gallery">
                    @foreach ($medias as $media)
                        <div class="media-preview {{ $this->isSelected($media->path) ? '-selected' : '' }}"
                            wire:click.prevent="handleMediaClick('{{ $media->path }}')">
                            <x-filament::avatar
                                src="{{ SimpleCmsImage::isResizable($media->path) ? SimpleCmsImage::imageUrl($media->path, 100, 100, true) : '' }}"
                                :circular="false" alt="" size="w-20 h-20" />
                        </div>
                    @endforeach
                </div>
                {{ $medias->links() }}
                <div>
                    <x-filament::button wire:click.prevent="confirm">
                    Valider
                </x-filament::button>
                </div>
            </x-filament::modal>
        </div>
    </div>
</div>
