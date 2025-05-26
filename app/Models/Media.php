<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $table = 'medias';

    protected $fillable = [
        'path',
        'name',
    ];

    public function getUrl(): string
    {
        return asset('storage/' . $this->path);
    }
}
