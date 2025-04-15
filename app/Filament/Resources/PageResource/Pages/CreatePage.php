<?php

declare(strict_types=1);

namespace App\Filament\Resources\PageResource\Pages;

use App\Filament\Resources\ContentResource\Pages\CreateContent;
use App\Filament\Resources\PageResource;

class CreatePage extends CreateContent
{
    protected static string $resource = PageResource::class;
}
