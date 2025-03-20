<nav aria-label="{{ $title }}" {{ $attributes }}>
    <x-simple-cms::menu.level :children="$items" :level="1" class="simple-cms-menu flex flex-col gap-2 lg:flex-row"
        role="menubar" aria-label="{{ $title }}" />
</nav>
