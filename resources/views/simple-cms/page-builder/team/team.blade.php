@props([
    'bgColor' => '',
    'members' => [],
])

<section class="py-5 xl:py-16  {{ $bgColor }}">
    <div class="px-5 mx-auto flex flex-col gap-5 md:grid md:grid-cols-2 lg:grid-cols-3 xl:max-w-10/12">
        @foreach ($members as $member)
            <x-simple-cms::page-builder.team.team-member :data="$member"/>
        @endforeach
    </div>
</section>
