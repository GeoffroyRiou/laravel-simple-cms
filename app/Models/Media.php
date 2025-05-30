<?php

declare(strict_types=1);

namespace App\Models;

use App\Services\ImageService;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $table = 'medias';

    protected $fillable = [
        'path',
        'name',
        'type',
    ];

    protected static function boot(): void
    {
        parent::boot();
        $imageService = app(ImageService::class);
        static::creating(function (Media $model) use ($imageService): void {
            $model->type = $imageService->isResizable($model->path) || $imageService->isSVG($model->path) ? 'image' : 'file';
        });

        static::updating(function (Media $model) use ($imageService): void {
            $model->type = $imageService->isResizable($model->path) || $imageService->isSVG($model->path) ? 'image' : 'file';
        });
    }

    public function getUrl(): string
    {
        return asset('storage/'.$this->path);
    }
}
