<?php

declare(strict_types=1);

namespace Jhg\NexmoBundle\Managers;

use Jhg\NexmoBundle\NexmoClient\NexmoClient;

/**
 * Class NumberManager
 *
 * @Author Javi Hernández
 */
class NumberManager
{
    private $nexmoClient;

    public function __construct(NexmoClient $nexmoClient)
    {
        $this->nexmoClient = $nexmoClient;
    }

    public function search(): void
    {
        throw new \Exception(__METHOD__.' not yet implemented');
    }

    public function buy(): void
    {
        throw new \Exception(__METHOD__.' not yet implemented');
    }

    public function cancel(): void
    {
        throw new \Exception(__METHOD__.' not yet implemented');
    }

    public function update(): void
    {
        throw new \Exception(__METHOD__.' not yet implemented');
    }
}
