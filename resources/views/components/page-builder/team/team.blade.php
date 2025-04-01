@props([
    'bgColor' => '',
    'members' => [],
    'spacer' => '',
])

<section class="{{ $spacer }} {{ $bgColor }}">
    <div class="px-5 mx-auto flex flex-col gap-5 md:flex-row md:flex-wrap md:justify-center xl:max-w-10/12">
        @foreach ($members as $member)
            <x-page-builder.team.team-member :data="$member" class="md:flex-[1_1_40%] md:max-w-[40%] lg:flex-[1_1_30%] lg:max-w-[30%] xl:flex-[1_1_20%] xl:max-w-[20%]"/>
        @endforeach
    </div>
</section>
