<?php

declare(strict_types=1);

namespace App\Filament\Resources\PageResource\Pages;

use App\Filament\Resources\ContentResource\Pages\ListContents;
use App\Filament\Resources\PageResource;

class ListPages extends ListContents
{
    protected static string $resource = PageResource::class;
}
