<x-dynamic-component :component="$getFieldWrapperView()" :field="$field" x-data="{
    state: $wire.$entangle('{{ $getStatePath() }}'),
    multiple: {{ $isMultiple() ? 1 : 0 }},
    remove: function(media, el) {
        this.state = this.state.filter(x => x !== media);
            el.parentElement.remove();
    },
}">
    <div>
        <div x-show="state">
            @if ($medias = $getMediaFiles())
                <div class="media-gallery -line">
                    <div class="list">
                        @foreach ($medias as $media)
                            <div class="media-preview">
                                <x-admin-file-preview :path="$media->path"/>
                                <p class="name">{{ $media->name }}</p>
                                <div class="overlay"
                                    x-on:click="(e) => remove('{{ $media->path }}',e.target)" >
                                    <x-icon name="heroicon-o-trash" class="icon" />
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
        <div class="pt-2">
            {{ $getAction('picker') }} ou {{ $getAction('upload') }}
        </div>

    </div>
</x-dynamic-component>
