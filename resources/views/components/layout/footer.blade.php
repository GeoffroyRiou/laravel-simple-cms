<?php

declare(strict_types=1);

?>
<footer class="bg-dark text-light px-5 py-10 md:py-16">
    <div class="max-w-10/12 mx-auto">
        <div>
            @foreach ($settings as $setting)
                <x-setting :$setting />
            @endforeach
        </div>
    </div>
</footer>
<?php 
