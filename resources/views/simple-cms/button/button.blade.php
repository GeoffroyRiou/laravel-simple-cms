@use('Illuminate\View\ComponentAttributeBag')
@props(['variant','class' => ''])

@if(!empty($data['url']))
    @php
        $data['class'] = $class;
        $attributes = new ComponentAttributeBag($data);
    @endphp
    <x-dynamic-component :component="'simple-cms::button.'.$variant" :$attributes />
@endif
