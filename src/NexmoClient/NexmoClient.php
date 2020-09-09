<?php
namespace Jhg\NexmoBundle\NexmoClient;

use Jhg\NexmoBundle\NexmoClient\Exceptions\NexmoClientException;
use Jhg\NexmoBundle\NexmoClient\Exceptions\QuotaExcededException;
use Jhg\NexmoBundle\NexmoClient\Exceptions\UnroutableSmsMessageException;
use Psr\Log\LoggerInterface;

class NexmoClient {

    /**
     * @var string
     */
    protected $rest_url;

    /**
     * @var string
     */
    protected $api_key;

    /**
     * @var string
     */
    protected $api_secret;

    /**
     * @var string
     */
    protected $api_method;

    /**
     * @var string
     */
    protected $delivery_phone;

    /**
     * @var boolean
     */
    protected $disable_delivery;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @param $api_key
     * @param $api_secret
     * @param string $api_method GET|POST configured in Nexmo API preferences
     * @param string $delivery_phone
     * @param boolean $disable_delivery
     * @param LoggerInterface $logger
     */
    public function __construct($api_key,$api_secret,$api_method='GET',$delivery_phone,$disable_delivery=false,LoggerInterface $logger) {
        $this->rest_url = 'https://rest.nexmo.com';
        $this->api_key = $api_key;
        $this->api_secret = $api_secret;
        $this->api_method = $api_method;
        $this->delivery_phone = $delivery_phone;
        $this->disable_delivery = $disable_delivery;
        $this->logger = $logger;
    }

    /**
     * @param $url
     * @param array $params
     * @return array
     */
    protected function jsonRequest($url,$params=array()) {

        $params['api_key'] = $this->api_key;
        $params['api_secret'] = $this->api_secret;

        $request_url = $this->rest_url.'/'.trim($url,'/').'?'.http_build_query($params);

        $request = curl_init($request_url);
        curl_setopt($request,CURLOPT_RETURNTRANSFER,true );
        curl_setopt($request,CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($request, CURLOPT_HTTPHEADER,array('Accept: application/json'));

        $response = curl_exec($request);
        $curl_info = curl_getinfo($request);
        $http_response_code = (int)$curl_info['http_code'];
        curl_close($request);

        switch($http_response_code) {
            case 200:
                return json_decode($response,true);
        }
    }


    /**
     * @example {"autoReload":false,"value":0.2}
     * @return array
     */
    public function accountBalance() {
        return $this->jsonRequest('/account/get-balance');
    }


    /**
     * @param $country
     * @return array[country=ES,mt=0.060000,name=Spain,prefix=34]
     */
    public function accountSmsPrice($country) {
        return $this->jsonRequest('/account/get-pricing/outbound',array('country'=>$country));
    }

    /**
     * @param string $fromName
     * @param string $toNumber
     * @param string $text
     * @param int $status_report_req
     * @return array
     * @throws \Exception
     */
    public function sendTextMessage($fromName,$toNumber,$text,$status_report_req=0) {
        $this->logger->debug("Nexmo sendTextMessage from $fromName to $toNumber with text '$text'");

        // delivery phone for development
        if($this->delivery_phone) {
            $toNumber = $this->delivery_phone;

            $this->logger->debug("Nexmo sendTextMessage delivery to $toNumber");
        }

        $params = array(
            'from'=>$fromName,
            'to'=>$toNumber,
            'text'=>$text,
            'status-report-req'=>$status_report_req,
        );

        if($this->disable_delivery) {
            $this->logger->debug("Nexmo sendTextMessage delivery disabled by config");
            return array(
                "status" => "0",
                "message-id" => "delivery-disabled",
                "to" => $toNumber,
                "client-ref" => 0,
                "remaining-balance" => 0,
                "message-price" => 0,
                "network" => 0,
            );
        }

        $response = $this->jsonRequest('/sms/json',$params);

        if(0 !==  $code = (int)$response['messages'][0]['status']) {
            $error = $response['messages'][0]['error-text'];
            switch( $code) {
                case 6:
                    throw new UnroutableSmsMessageException($error, $code);

                case 9:
                    throw new QuotaExcededException($error, $code);

                default:
                    throw new NexmoClientException($error, $code);
            }
        }

        return $response['messages'][0];
    }
}