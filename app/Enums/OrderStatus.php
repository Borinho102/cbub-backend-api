<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

/**
 * @method static static Pending()
 * @method static static Approved()
 * @method static static Paid()
 * @method static static Canceled()
 * @method static static Refunded()
 * @method static static Delivered()
 */
final class OrderStatus extends Enum implements LocalizedEnum
{
    const Pending = 'pending';
    const Approved = 'approved';
    const Paid = 'paid';
    const Canceled = 'canceled';
    const Refunded = 'refunded';
    const Delivered = 'delivered';
}
