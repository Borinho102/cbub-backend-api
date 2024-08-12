<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Default()
 * @method static static NewProduct()
 * @method static static ProductDiscount()
 * @method static static Publicity()
 * @method static static Announcement()
 * @method static static PromoCode()
 */
final class NotificationType extends Enum
{
    const Default = 'default';
    const NewProduct = 'new-product';
    const ProductDiscount = 'product-discount';
    const Publicity = 'publicity';
    const Announcement = 'announcement';
    const PromoCode = 'promo-code';
}
