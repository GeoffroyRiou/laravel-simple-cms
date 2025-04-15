<?php

declare(strict_types=1);

?>
@props([
    'bgColor' => '',
    'numbers' => [],
    'topSpacer' => '',
    'bottomSpacer' => '',
])
<section class="{{ $bgColor }} {{ $topSpacer }} {{ $bottomSpacer }}">
    <div class="mx-auto px-5 flex flex-col gap-5 md:flex-row md:justify-center xl:max-w-10/12">
        @foreach ($numbers as $number)
            <div
                class="p-5 flex flex-col gap-5 items-center bg-white border border-primary rounded-lg md:py-8 md:flex-[1_1_40%] md:max-w-[40%] lg:flex-[1_1_30%] lg:max-w-[30%] xl:flex-[1_1_20%] xl:max-w-[20%]">
                @if (!empty($number['picto']))
                    <figure class="w-20 h-20 bg-primary/50 rounded-full flex justify-center items-center">
                        <img src="{{ Storage::url($number['picto']) }}" alt="" class="w-10 h-10" loading="lazy"
                            class="icon" />
                    </figure>
                @endif
                <div class="flex flex-col gap-3 text-center">
                    <p class="text-4xl font-bold text-primary">{{ $number['number'] }}</p>
                    <p class="text-sm italic">{{ $number['description'] }}</p>
                </div>
            </div>
        @endforeach
    </div>
</section>
<?php 
