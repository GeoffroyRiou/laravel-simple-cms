<x-simple-cms::layout>
    <h1 class="text-center text-3xl p-10">{{ $model->title }}</h1>

    {{ $model->illustration }}

    <x-simple-cms::page-builder :model="$model" />
</x-simple-cms::layout>
