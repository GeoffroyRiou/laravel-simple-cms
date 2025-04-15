<?php

declare(strict_types=1);

?>
    <ul {{ $attributes->merge(['class' => 'flex flex-col gap-3 items-center lg:flex-row']) }} role="menubar">
        @foreach ($items as $item)
            @php
                $hasChildren = !empty($item['children']);
            @endphp
            <li role="none" class="relative" x-data="{ open: false}" @if ($hasChildren) x-on:click.outside="open = false" @endif>
                <span class="flex items-center gap-3 rounded-md px-3 py-2 text-sm font-medium text-light hover:bg-primary" :class="{ 'rounded-b-none bg-primary': open }">
                    <a role="menuitem" href="{{ $item['url'] ?? '' }}"
                        @if ($item['blank']) target="_blank" @endif
                        class="flex gap-2 items-center "
                        @if ($hasChildren) aria-haspopup="true" aria-expanded="false" @endif>
                        {{ $item['label'] }}
                    </a>

                    @if ($hasChildren)
                        <button type="button" class="p-0.5 cursor-pointer" @click="open = !open">
                            <x-icon-arrow-down class="w-4 h-4 text-light" />
                        </button>
                    @endif
                </span>
                @if (!empty($item['children']))
                    <ul x-show="open" class="absolute top-full left-0 z-10 bg-primary rounded-md rounded-tl-none text-light shadow-lg py-2">
                        @foreach ($item['children'] as $child)
                            <li role="none" class="relative">
                                <span>
                                    <a role="menuitem" href="{{ $child['url'] ?? '' }}"
                                        @if ($child['blank']) target="_blank" @endif
                                        class="flex gap-2 items-center px-3 py-2 text-sm font-medium whitespace-nowrap">
                                        {{ $child['label'] }}
                                    </a>
                                </span>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </li>
        @endforeach
    </ul>
<?php 
