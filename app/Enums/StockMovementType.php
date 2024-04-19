<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static In()
 * @method static static Out()
 */
final class StockMovementType extends Enum
{
    const In = 'in';
    const Out = 'out';
}
