<?php

declare(strict_types=1);

?>
<x-layout>
    <h1 class="text-center text-3xl p-10">{{ $model->title }}</h1>

    <x-page-builder :model="$model" />
</x-layout>
<?php 
