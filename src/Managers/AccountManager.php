<?php

declare(strict_types=1);

namespace Jhg\NexmoBundle\Managers;

use Jhg\NexmoBundle\NexmoClient\NexmoClient;

/**
 * Class AccountManager
 *
 * @Author Javi Hernández
 */
class AccountManager
{
    private $nexmoClient;

    public function __construct(NexmoClient $nexmoClient)
    {
        $this->nexmoClient = $nexmoClient;
    }

    public function balance(): float
    {
        $response = $this->nexmoClient->accountBalance();

        return floatval($response['value']);
    }

    public function smsPricing(string $country): float
    {
        $response = $this->nexmoClient->accountSmsPrice($country);

        return floatval($response['mt']);
    }

    /**
     * @todo Implement getCountryDialingCode method
     *
     * @param string $country_code
     *
     * @throws \Exception
     */
    public function getCountryDialingCode($country_code): void
    {
        throw new \Exception(__METHOD__.' not yet implemented');
    }

    /**
     * @todo Implement numbersList method
     *
     * @throws \Exception
     */
    public function numbersList(): void
    {
        throw new \Exception(__METHOD__.' not yet implemented');
    }

    /**
     * @todo Implement numbersSearch method
     *
     * @param string $country_code
     * @param string $pattern
     *
     * @throws \Exception
     */
    public function numbersSearch($country_code, $pattern): void
    {
        throw new \Exception(__METHOD__.' not yet implemented');
    }

    /**
     * @todo Implement numbersBuy method
     *
     * @param string $country_code
     * @param string $msisdn
     *
     * @throws \Exception
     */
    public function numbersBuy($country_code, $msisdn): void
    {
        throw new \Exception(__METHOD__.' not yet implemented');
    }

    /**
     * @todo Implement numbersCancel method
     *
     * @throws \Exception
     */
    public function numbersCancel(): void
    {
        throw new \Exception(__METHOD__.' not yet implemented');
    }
}
