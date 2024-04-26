<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static TopBusinessCard()
 * @method static static TopProductCard()
 * @method static static TopCustomerCard()
 * @method static static TopBusinessChart()
 */
final class DashboardStatisticType extends Enum
{
    const TopBusinessCard = 1;
    const TopProductCard = 2;
    const TopCustomerCard = 3;
    const TopBusinessChart = 4;
}
