<?php

declare(strict_types=1);

namespace App\Traits;

trait HasSeo
{
    /**
     * This method is called upon instantiation of the Eloquent Model.
     * It adds seo fields to the "$fillable" array of the model.
     *
     * @return void
     */
    public function initializeHasSeo()
    {
        $this->fillable[] = 'seo_title';
        $this->fillable[] = 'seo_description';
        $this->translatable[] = 'seo_title';
        $this->translatable[] = 'seo_description';
    }
}
