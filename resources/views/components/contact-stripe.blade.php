@props(['showAddress' => true, 'showPhone' => true])

<address {{ $attributes->merge(['class' => 'contact-stripe']) }}>

    @if ($showAddress && !empty($settings['adresse']))
        <x-setting :setting="$settings['adresse']" />
    @endif

    @if ($showPhone && !empty($settings['adresse']))
        <x-setting :setting="$settings['telephone']" />
    @endif
</address>
