<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

/**
 * @method static static Popular()
 * @method static static Featured()
 * @method static static New()
 * @method static static TodayDeal()
 */
final class ProductTagType extends Enum implements LocalizedEnum
{
    const Popular = 'popular';
    const Featured = 'featured';
    const New = 'new';
    const TodayDeal = 'today-deal';
}
