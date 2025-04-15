<?php

declare(strict_types=1);

namespace App\Filament\Resources\PageResource\Pages;

use App\Filament\Resources\ContentResource\Pages\EditContent;
use App\Filament\Resources\PageResource;

class EditPage extends EditContent
{
    protected static string $resource = PageResource::class;
}
