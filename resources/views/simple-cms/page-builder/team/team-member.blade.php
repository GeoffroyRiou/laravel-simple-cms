@props(['data' => []])

<div {{ $attributes->merge(['class' => 'group bg-white border border-indigo-200 rounded-lg p-5 text-center']) }}>

    @if (!empty($data['image']))
        <x-simple-cms::image :path="$data['image']" width="150" height="150" crop="true" class="rounded-full mx-auto" />
    @endif

    <div class="p-4">
        <p class="text-lg font-medium">{{ $data['name'] }}</p>

        @if (!empty($data['job']))
            <p class="text-xs">{{ $data['job'] }}</p>
        @endif

        @if (!empty($data['text']))
            <p class="mt-5 line-clamp-3 text-sm/relaxed">
                {!! $data['text'] !!}
            </p>
        @endif
    </div>
</div>
