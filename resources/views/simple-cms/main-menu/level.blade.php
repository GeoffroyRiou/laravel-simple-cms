@props(['children' => [], 'level' => 1])

<ul {{ $attributes->merge(['class' => 'flex gap-3 items-center']) }}>
    @foreach ($children as $item)
        @php
            $hasChildren = !empty($item['children']);
        @endphp
        <li role="none" class="relative">
            <a role="menuitem" href="{{ $item['url'] ?? '' }}" @if ($item['blank']) target="_blank" @endif
                class="flex gap-2 items-center {{ $level == 1 ? 'rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white' : 'px-3 py-2 text-sm font-medium text-gray-900' }}"
                @if ($hasChildren) aria-haspopup="true" aria-expanded="false" @endif>
                {{ $item['label'] }} {{ $hasChildren ? '+' : '' }}
            </a>
            @if (!empty($item['children']))
                <x-simple-cms::main-menu.level :children="$item['children']" role="menu" aria-label="{{ $item['label'] }}"
                    :level="$level + 1" class="absolute whitespace-nowrap hidden bg-white rounded-md shadow-lg" />
            @endif
        </li>
    @endforeach
</ul>
