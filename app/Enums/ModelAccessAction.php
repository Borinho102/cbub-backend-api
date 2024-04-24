<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Search()
 * @method static static Click()
 * @method static static Wishlist()
 */
final class ModelAccessAction extends Enum
{
    const Search = 'search';
    const Click = 'click';
    const Wishlist = 'wishlist';
}
