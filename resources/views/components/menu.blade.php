<?php

declare(strict_types=1);

?>
    <ul {{ $attributes->merge(['class' => '']) }} role="menubar">
        @foreach ($items as $item)
            @php
                $hasChildren = !empty($item['children']);
            @endphp
            <li role="none" class="relative" x-data="{ open: false}" @if ($hasChildren) x-on:click.outside="open = false" @endif>
                <span  :class="{ 'is-opened': open }">
                    <a role="menuitem" href="{{ $item['url'] ?? '' }}"
                        @if ($item['blank']) target="_blank" @endif
                        @if ($hasChildren) aria-haspopup="true" aria-expanded="false" @endif>
                        {{ $item['label'] }}
                    </a>

                    @if ($hasChildren)
                        <button type="button" @click="open = !open">
                            <x-icon-arrow-down class="arrow"/>
                        </button>
                    @endif
                </span>
                @if (!empty($item['children']))
                    <ul x-show="open">
                        @foreach ($item['children'] as $child)
                            <li role="none" class="relative">
                                <span>
                                    <a role="menuitem" href="{{ $child['url'] ?? '' }}"
                                        @if ($child['blank']) target="_blank" @endif >
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
