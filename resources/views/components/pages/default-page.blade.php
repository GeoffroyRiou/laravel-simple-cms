<x-layout :$model>

    @if (!empty($model->illustration))
        <x-picture :path="$model->illustration" :sizes="[
            ['breakpoint' => '', 'width' => 760, 'height' => 400, 'crop' => true],
            ['breakpoint' => 'min-width:760px', 'width' => 1920, 'height' => 500, 'crop' => true],
        ]" class="w-full" />
    @endif

    <x-page-header :title="$model->title" />
    <x-page-builder :model="$model" />
</x-layout>
