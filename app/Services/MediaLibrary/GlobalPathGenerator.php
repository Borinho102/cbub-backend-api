<?php

namespace App\Services\MediaLibrary;

use App\Models\Admin;
use App\Models\Business;
use App\Models\BusinessUser;
use App\Models\Notification;
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

        return match ($media->model_type) {
            User::class => $prefix . '/users/' . $media->model_id . '/' . $media->id,
            BusinessUser::class => $prefix . '/business_users/' . $media->model_id . '/' . $media->id,
            Admin::class => $prefix . '/admins/' . $media->model_id . '/' . $media->id,
            Product::class => $prefix . '/products/' . $media->model_id . '/' . $media->id,
            ProductCategory::class => $prefix . '/product_categories/' . $media->model_id . '/' . $media->id,
            Business::class => $prefix . '/businesses/' . $media->model_id . '/' . $media->id,
            Shop::class => $prefix . '/shops/' . $media->model_id . '/' . $media->id,
            Notification::class => $prefix . '/notifications/' . $media->model_id . '/' . $media->id,
            default => $prefix . '/' .  $media->getKey()
        };
    }
}
