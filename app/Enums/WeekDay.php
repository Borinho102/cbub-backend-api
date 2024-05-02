<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

/**
 * @method static static Sunday()
 * @method static static Monday()
 * @method static static Tuesday()
 * @method static static Wednesday()
 * @method static static Thursday()
 * @method static static Friday()
 * @method static static Saturday()
 */
final class WeekDay extends Enum implements LocalizedEnum
{
    const Sunday = 'sunday';
    const Monday = 'monday';
    const Tuesday = 'tuesday';
    const Wednesday = 'wednesday';
    const Thursday = 'thursday';
    const Friday = 'friday';
    const Saturday = 'saturday';
}
