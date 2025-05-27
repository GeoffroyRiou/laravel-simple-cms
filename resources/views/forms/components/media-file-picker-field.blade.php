<x-dynamic-component :component="$getFieldWrapperView()" :field="$field" x-data="{
    state: $wire.$entangle('{{ $getStatePath() }}'),
    multiple: {{ $isMultiple() ? 1 : 0 }},
    select: function(media) {
        if (!this.multiple) {
            this.state = [media];
        } else if (this.state.find(x => x === media)) {
            this.state = this.state.filter(x => x !== media);
        } else {
            this.state.push(media);
        }
    },
    isChecked: function(media) {
        if(!this.state) return false;
        return this.state.find(x => x === media) !== undefined;
    },
}">
    <div class="media-gallery">
        <div class="list">
            @foreach ($getMediaFiles() as $media)
                <label for="media_{{ $media->id }}" wire:key="media_{{ $media->id }}" class="media-preview"
                    :class="{ '-selected': isChecked('{{ $media->path }}') }">
                    <input type="{{ $isMultiple() ? 'checkbox' : 'radio' }}" id="media_{{ $media->id }}" name="media"
                        :checked="isChecked('{{ $media->path }}')" x-on:change="select('{{ $media->path }}')"
                        class="hidden">
                    <x-admin-file-preview :path="$media->path" />
                    <p class="name">{{ $media->name }}</p>
                </label>
            @endforeach
        </div>
    </div>
</x-dynamic-component>
