@props([
    'bgColor' => '',
    'buttons' => []
])

<section class="{{ $bgColor }} py-5 ">
    <div class="mx-auto px-5 flex flex-col gap-2 md:flex-row md:justify-center xl:max-w-10/12">
        @foreach ($buttons as $button)
            <x-simple-cms::button :data="$button" class="w-full md:w-fit"/>
        @endforeach
    </div>
</section>