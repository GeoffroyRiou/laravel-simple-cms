@use('Illuminate\View\ComponentAttributeBag')
@props(['class' => ''])

@if(!empty($data['url']))
    @php
        $data['class'] = $class;
        $attributes = new ComponentAttributeBag($data);
        $variant = $data['variant'] ?? 'primary';
    @endphp
    <x-dynamic-component :component="'simple-cms::button.'.$variant" :$attributes />
@endif
