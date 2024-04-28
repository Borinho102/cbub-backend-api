<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static TopShopCard()
 * @method static static TopProductCard()
 * @method static static TopCustomerCard()
 * @method static static TopBusinessChart()
 * @method static static LatestOrderCard()
 * @method static static TotalSalesThisWeek()
 * @method static static NewOrdersThisWeek()
 * @method static static NewCustomersThisWeek()
 */
final class DashboardStatisticType extends Enum
{
    const TopShopCard = 1;
    const TopProductCard = 2;
    const TopCustomerCard = 3;
    const TopBusinessChart = 4;
    const LatestOrderCard = 5;
    const TotalSalesThisWeek = 6;
    const NewOrdersThisWeek = 7;
    const NewCustomersThisWeek = 8;
}
