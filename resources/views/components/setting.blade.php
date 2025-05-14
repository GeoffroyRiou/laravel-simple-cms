@props(['setting'])

@if (!empty($setting))
    <div {{ $attributes->merge(['class' => 'flex items-center gap-2 group']) }}>
        @if (!empty($setting->icon))
            <x-dynamic-component :component="$setting->icon" class="size-5" />
        @endif
        <span class="border-r w-px bg-primary dark:bg-light h-3 opacity-50"></span>
        @switch($setting->type)
            @case('Email')
            @case('Phone')
                <a href="{{ $setting->type == 'Phone' ? 'tel' : 'mailto' }}:{{ $setting->value }}"
                    class="text-sm font-title font-medium transition-colors hover:underline">{{ $setting->value }}</a>
            @break

            @case('Text area')
                <p class="text-sm font-title font-medium">{!! nl2br($setting->value) !!}</p>
            @break

            @default
                <p class="text-sm font-title font-medium">{{ $setting->value }}</p>
            @break
        @endswitch
    </div>
@endif
