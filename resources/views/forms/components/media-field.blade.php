<x-dynamic-component :component="$getFieldWrapperView()" :field="$field" x-data="{
    state: $wire.$entangle('{{ $getStatePath() }}'),
    multiple: {{ $isMultiple() ? 1 : 0 }},    
    showUpload: {{ $getShowUpload() ? 1 : 0 }},
    showPicker: {{ $getShowPicker() ? 1 : 0 }},
    max: {{ $getMax() ?? 0 }},
    showAddImageButtons : function() {
        const state = this.state || [];
        return !this.max || (this.max && state.length < this.max) ;
    },
    remove: function(media, el) {
        this.state = Array.isArray(this.state) ? this.state : [];
        this.state = this.state.filter(x => x !== media);
            el.parentElement.remove();
    },
}">
    <div class="flex gap-5 items-center">
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
        <div class="pt-2 flex flex-col gap-3" x-show="showAddImageButtons()">
            {{ $getAction('picker') }}
            {{ $getAction('upload') }}
        </div>

    </div>
</x-dynamic-component>
