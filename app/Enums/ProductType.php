<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Digital()
 * @method static static Physical()
 * @method static static Service()
 */
final class ProductType extends Enum
{
    const Digital = 'digital';
    const Physical = 'physical';
    const Service = 'service';
}
