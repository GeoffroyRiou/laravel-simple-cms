
<x-simple-cms::layout>
    <h1 class="text-center text-3xl p-10">{{ $model->title }}</h1>

    <x-simple-cms::image :path="$model->illustration" width="1000" height="500" crop="true"  />

    <x-simple-cms::page-builder :model="$model" />
</x-simple-cms::layout>
