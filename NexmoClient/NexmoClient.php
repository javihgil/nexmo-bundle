<?php

namespace Jhg\NexmoBundle\NexmoClient;

use Exception;
use Jhg\NexmoBundle\NexmoClient\Exceptions\NexmoClientException;
use Jhg\NexmoBundle\NexmoClient\Exceptions\QuotaExcededException;
use Jhg\NexmoBundle\NexmoClient\Exceptions\UnroutableSmsMessageException;
use NexmoClient\NexmoResponseCodes;
use Psr\Log\LoggerInterface;

/**
 * Represents a client connection to the Nexmo Api.
 *
 * @package Jhg\NexmoBundle\NexmoClient
 */
class NexmoClient
{

    /**
     * The API endpoint.
     *
     * @var string
     */
    protected $rest_url;

    /**
     * A unique key that will be used to perform connections to the API.
     *
     * @var string
     */
    protected $api_key;

    /**
     * A unique password that will be used to validate the connection requested to the API.
     *
     * @var string
     */
    protected $api_secret;

    /**
     * The request method.
     *
     * This can be POST, GET, etc.
     *
     * @var string
     */
    protected $api_method;

    /**
     * The destination phone number.
     *
     * @var string
     */
    protected $delivery_phone;

    /**
     * A boolean representation which, when set to true, will disable the API true SMS deliver and return a debug
     * information of the process.
     *
     * Defaults to false.
     *
     * @var boolean
     */
    protected $disable_delivery;

    /**
     * The Logger instance that will be used to log exception scenarios.
     *
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * NexmoClient constructor
     *
     * @param                 $api_key
     * @param                 $api_secret
     * @param string          $api_method GET|POST configured in Nexmo API preferences
     * @param string          $delivery_phone
     * @param boolean         $disable_delivery
     * @param LoggerInterface $logger
     */
    public function __construct(
        $api_key,
        $api_secret,
        $api_method = 'GET',
        $delivery_phone,
        $disable_delivery = false,
        LoggerInterface $logger
    ) {
        $this->rest_url         = 'https://rest.nexmo.com';
        $this->api_key          = $api_key;
        $this->api_secret       = $api_secret;
        $this->api_method       = $api_method;
        $this->delivery_phone   = $delivery_phone;
        $this->disable_delivery = $disable_delivery;
        $this->logger           = $logger;
    }

    /**
     * Use this method to perform a json API request for a given endpoint.
     *
     * @param       $url
     * @param array $params
     *
     * @return array
     */
    protected function jsonRequest($url, $params = array())
    {

        $params['api_key']    = $this->api_key;
        $params['api_secret'] = $this->api_secret;

        $request_url = $this->rest_url . '/' . trim($url, '/') . '?' . http_build_query($params);

        $request = curl_init($request_url);
        curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($request, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($request, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);
        curl_setopt($request, CURLOPT_HTTPHEADER, array('Accept: application/json'));

        $response           = curl_exec($request);
        $curl_info          = curl_getinfo($request);
        $http_response_code = (int)$curl_info['http_code'];
        curl_close($request);

        switch ($http_response_code) {
            case 200:
                $parsedResponse = json_decode($response, true);
                break;
            default:
                $parsedResponse = array(
                    'messages' => array(
                        array (
                            'error-text' => "Failed HTTP error: {$http_response_code}"
                            ,'status'    => NexmoResponseCodes::ERROR_GENERAL
                        )
                    )
                );
        }

        return $parsedResponse;
    }


    /**
     * Use this method to retrieve the account balance.
     *
     * @example {"autoReload":false,"value":0.2}
     *
     * @return array
     */
    public function accountBalance()
    {
        return $this->jsonRequest('/account/get-balance');
    }


    /**
     * Use this method to retrieve the sms pricing for a given country.
     *
     * @param $country
     *
     * @return array[country=ES,mt=0.060000,name=Spain,prefix=34]
     */
    public function accountSmsPrice($country)
    {
        return $this->jsonRequest('/account/get-pricing/outbound', array('country' => $country));
    }

    /**
     * Use this method to send a sms message to a given destination.
     *
     * @param string $fromName
     * @param string $toNumber
     * @param string $text
     * @param int    $status_report_req
     *
     * @return array
     *
     * @throws Exception
     */
    public function sendTextMessage($fromName, $toNumber, $text, $status_report_req = 0)
    {
        $this->logger->debug("Nexmo sendTextMessage from $fromName to $toNumber with text '$text'");

        // delivery phone for development
        if ($this->delivery_phone) {
            $toNumber = $this->delivery_phone;

            $this->logger->debug("Nexmo sendTextMessage delivery to $toNumber");
        }

        $params = array(
            'from'              => $fromName,
            'to'                => $toNumber,
            'text'              => $text,
            'status-report-req' => $status_report_req,
        );

        if ($this->disable_delivery) {
            $this->logger->debug("Nexmo sendTextMessage delivery disabled by config");

            return array(
                "status"            => "0",
                "message-id"        => "delivery-disabled",
                "to"                => $toNumber,
                "client-ref"        => 0,
                "remaining-balance" => 0,
                "message-price"     => 0,
                "network"           => 0,
            );
        }

        $response = $this->jsonRequest('/sms/json', $params);

        if (0 !== $code = (int)$response['messages'][0]['status']) {
            $error = $response['messages'][0]['error-text'];
            switch ($code) {
                case NexmoResponseCodes::ERROR_ANTI_SPAM_REJECTION:
                    throw new UnroutableSmsMessageException($error, $code);

                case NexmoResponseCodes::ERROR_ILLEGAL_NUMBER:
                    throw new QuotaExcededException($error, $code);

                default:
                    throw new NexmoClientException($error, $code);
            }
        }

        return $response['messages'][0];
    }
}