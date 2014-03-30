<?php
namespace Jhg\NexmoBundle\Utils;

/**
 * Class PhoneNumber
 * @package Jhg\NexmoBundle\Utils
 * @Author Javi Hernández
 */
class PhoneNumber {
    /**
     * @param $number
     * @return mixed
     */
    public static function prefixFilter($number) {
        return str_ireplace('+','00',$number);
    }
} 