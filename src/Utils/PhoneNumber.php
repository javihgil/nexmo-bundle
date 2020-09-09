<?php

declare(strict_types=1);

namespace Jhg\NexmoBundle\Utils;

class PhoneNumber
{
    public static function prefixFilter(string $number): string
    {
        return str_ireplace('+', '00', $number);
    }
}
