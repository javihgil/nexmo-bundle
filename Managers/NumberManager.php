<?php
namespace Jhg\NexmoBundle\Managers;

use Jhg\NexmoBundle\NexmoClient\NexmoClient;

/**
 * Class NumberManager
 * @package Jhg\NexmoBundle\Managers
 * @Author Javi Hernández
 */
class NumberManager
{
    /**
     * @var \Jhg\NexmoBundle\NexmoClient\NexmoClient
     */
    protected $nexmoClient;

    /**
     * @param NexmoClient $nexmoClient
     */
    public function __construct(NexmoClient $nexmoClient) {
        $this->nexmoClient = $nexmoClient;
    }

    public function search() {
        throw new \Exception(__METHOD__.' not yet implemented');
    }

    public function buy() {
        throw new \Exception(__METHOD__.' not yet implemented');
    }

    public function cancel() {
        throw new \Exception(__METHOD__.' not yet implemented');
    }

    public function update() {
        throw new \Exception(__METHOD__.' not yet implemented');
    }
}