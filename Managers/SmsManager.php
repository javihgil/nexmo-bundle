<?php
namespace Jhg\NexmoBundle\Managers;

use Jhg\NexmoBundle\Model\SmsSendResponse;
use Jhg\NexmoBundle\NexmoClient\NexmoClient;
use Jhg\NexmoBundle\Utils\PhoneNumber;

/**
 * Class SmsManager
 * @package Jhg\NexmoBundle\Managers
 * @Author Javi Hernández
 */
class SmsManager
{
    /**
     * @var \Jhg\NexmoBundle\NexmoClient\NexmoClient
     */
    protected $nexmoClient;

    /**
     * @var string
     */
    protected $defaultFromName;

    /**
     * @param NexmoClient $nexmoClient
     * @param $defaultFromName
     */
    public function __construct(NexmoClient $nexmoClient,$defaultFromName) {
        $this->nexmoClient = $nexmoClient;
        $this->defaultFromName = $defaultFromName;
    }

    /**
     * @param string $number
     * @param string $message
     * @param null|string $fromName
     * @param int $status_report_req
     * @return SmsSendResponse
     */
    public function sendText($number,$message,$fromName=null,$status_report_req=0) {
        $fromName = $fromName!==null ? $fromName : $this->defaultFromName;
        $number = PhoneNumber::prefixFilter($number);
        $response = $this->nexmoClient->sendTextMessage($fromName,$number,$message,$status_report_req);
        return SmsSendResponse::createFromResponse($response);
    }

    public function sendBinary() {
        throw new \Exception(__METHOD__.' not yet implemented');
    }

    public function sendWapPush() {
        throw new \Exception(__METHOD__.' not yet implemented');
    }

    public function searchMessage() {
        throw new \Exception(__METHOD__.' not yet implemented');
    }

    public function searchMessages() {
        throw new \Exception(__METHOD__.' not yet implemented');
    }

    public function searchRejections() {
        throw new \Exception(__METHOD__.' not yet implemented');
    }
}