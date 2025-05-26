<x-dynamic-component :component="$getFieldWrapperView()" :field="$field" x-data="{
    state: $wire.$entangle('{{ $getStatePath() }}'),
}">
    <div>
        <div x-show="state">
            @if ($medias = $getMediaFiles())
                @foreach($medias as $media)
                    <x-admin-file-preview :path="$media" />
                @endforeach
            @endif
        </div>
        <div class="pt-2">
            {{ $getAction('picker') }}  ou {{ $getAction('upload') }}
        </div>

    </div>
</x-dynamic-component>