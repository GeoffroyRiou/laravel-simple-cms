<x-simple-cms::layout :$model>
    <x-simple-cms::page-header :title="$model->title" />
    <x-simple-cms::page-builder :model="$model" />
</x-simple-cms::layout>
