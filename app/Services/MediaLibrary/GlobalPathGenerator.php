<?php

namespace App\Services\MediaLibrary;

use App\Models\Admin;
use App\Models\Business;
use App\Models\BusinessUser;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Shop;
use App\Models\User;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\PathGenerator\PathGenerator;


class GlobalPathGenerator implements PathGenerator
{
    /*
    * Get the path for the given media, relative to the root storage path.
    */
    public function getPath(Media $media): string
    {
        return $this->getBasePath($media).'/';
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

    /*
     * Get a unique base path for the given media.
     */
    protected function getBasePath(Media $media): string
    {
        $prefix = config('media-library.prefix', '');

        if ($media->model_type === User::class) {
            return $prefix . '/users/' . $media->model_id . '/' . $media->id;
        } else if ($media->model_type === BusinessUser::class) {
            return $prefix . '/business_users/' . $media->model_id . '/' . $media->id;
        } else if ($media->model_type === Admin::class) {
            return $prefix . '/admins/' . $media->model_id . '/' . $media->id;
        } else if ($media->model_type === Product::class) {
            return $prefix . '/products/' . $media->model_id . '/' . $media->id;
        } else if ($media->model_type === ProductCategory::class) {
            return $prefix . '/product_categories/' . $media->model_id . '/' . $media->id;
        } else if ($media->model_type === Business::class) {
            return $prefix . '/businesses/' . $media->model_id . '/' . $media->id;
        } else if ($media->model_type === Shop::class) {
            return $prefix . '/shops/' . $media->model_id . '/' . $media->id;
        }

        return $prefix . '/' .  $media->getKey();
    }
}
