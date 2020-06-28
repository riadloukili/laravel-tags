<?php

namespace Spatie\Tags;

use Illuminate\Database\Eloquent\Model;

trait HasSlug
{
    public static function bootHasSlug()
    {
        static::saving(function (Model $model) {
            collect(['en', 'ar'])
                ->each(function (string $locale) use ($model) {
                    if($locale == "ar"){
                        $model->slug_ar = $model->generateSlug($locale);
                    } else {
                        $model->slug = $model->generateSlug($locale);
                    }
                });
        });
    }

    protected function generateSlug(string $locale): string
    {
        $slugger = config('tags.slugger');

        $slugger = $slugger ?: '\Illuminate\Support\Str::slug';
        
        if($locale == "ar"){
            return call_user_func($slugger, $this->name_ar);
        }
        return call_user_func($slugger, $this->name);
    }
}
