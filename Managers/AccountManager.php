<?php
namespace Jhg\NexmoBundle\Managers;

use Jhg\NexmoBundle\NexmoClient\NexmoClient;

/**
 * Class AccountManager
 * @package Jhg\NexmoBundle\Managers
 * @Author Javi Hernández
 */
class AccountManager
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

    /**
     * @return bool|float - account balance | false on fail
     */
    public function balance() {
        $response = $this->nexmoClient->accountBalance();
        return floatval($response['value']);
    }

    /**
     * @param $country
     * @return bool|float - sms pricing | false on fail
     */
    public function smsPricing($country) {
        $response = $this->nexmoClient->accountSmsPrice($country);
        return floatval($response['mt']);
    }


    /**
     * @todo Implement getCountryDialingCode method
     * @param $country_code
     * @throws \Exception
     */
    public function getCountryDialingCode ($country_code) {
        throw new \Exception(__METHOD__.' not yet implemented');
    }

    /**
     * @todo Implement numbersList method
     * @throws \Exception
     */
    public function numbersList () {
        throw new \Exception(__METHOD__.' not yet implemented');
    }

    /**
     * @todo Implement numbersSearch method
     * @param $country_code
     * @param $pattern
     * @throws \Exception
     */
    public function numbersSearch ($country_code, $pattern) {
        throw new \Exception(__METHOD__.' not yet implemented');
    }

    /**
     * @todo Implement numbersBuy method
     * @param $country_code
     * @param $msisdn
     * @throws \Exception
     */
    public function numbersBuy ($country_code, $msisdn) {
        throw new \Exception(__METHOD__.' not yet implemented');
    }

    /**
     * @todo Implement numbersCancel method
     * @throws \Exception
     */
    public function numbersCancel() {
        throw new \Exception(__METHOD__.' not yet implemented');
    }
}