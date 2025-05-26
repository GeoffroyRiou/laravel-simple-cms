<x-dynamic-component :component="$getFieldWrapperView()" :field="$field" x-data="{
    state: $wire.$entangle('{{ $getStatePath() }}'),
}">
    <div class="media-gallery">
        @foreach ($getMediaFiles() as $media)
            <label for="media_{{ $media->id }}" wire:key="media_{{ $media->id }}" class="media-preview" :class="{ '-selected': state == '{{ $media->path }}' }">
                <input type="radio" id="media_{{ $media->id }}" :checked="state == '{{ $media->path }}'"
                    x-on:change="state = '{{ $media->path }}'" class="hidden">
                <x-admin-file-preview :path="$media->path" />
                <p class="name">{{$media->name}}</p>
            </label>
        @endforeach
    </div>
</x-dynamic-component>
