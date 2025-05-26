<x-dynamic-component  wire:key="uniqId()" :component="$getFieldWrapperView()" :field="$field">
    <div x-data="{
        state: $wire.$entangle('{{ $getStatePath() }}'),
    }">
        <input x-model="state" />
    </div>
    <livewire:media-gallery :selectedPaths="$field->getState($getStatePath()) ?? []" />
</x-dynamic-component>

@script
    <script>
        $wire.$on('pathSelected', function(data) {
            $wire.$set('{{ $getStatePath() }}', data.paths);
        })
    </script>
@endscript
