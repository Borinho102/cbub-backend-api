<?php

namespace App\Services\MediaLibrary;

use App\Models\Business;
use App\Models\Product;
use App\Models\User;
use App\Models\WaspitoPackage;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\PathGenerator\PathGenerator;


class GlobalPathGenerator implements PathGenerator
{
    /*
    * Get the path for the given media, relative to the root storage path.
    */
    public function getPath(Media $media): string
    {
        if ($media->model() instanceof User) {
            return 'users/' . $media->model->id . '/' . $media->id;
        } else if ($media->model() instanceof Product) {
            return 'businesses/' . $media->model->business_id . '/products/' . $media->model->id . '/' . $media->id;
        } else if ($media->model() instanceof Business) {
            return 'businesses/' . $media->model->id . '/' . $media->id;
        } else {
            return $media->id;
        }
    }

    /*
     * Get the path for conversions of the given media, relative to the root storage path.
     */
    public function getPathForConversions(Media $media): string
    {
        return $this->getPath($media) . 'conversions/';
    }

    /*
     * Get the path for responsive images of the given media, relative to the root storage path.
     */
    public function getPathForResponsiveImages(Media $media): string
    {
        return $this->getPath($media) . 'responsive/';
    }
}
