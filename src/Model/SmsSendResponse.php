<?php
namespace Jhg\NexmoBundle\Model;
use MyProject\Proxies\__CG__\stdClass;

/**
 * Class SmsSendResponse
 * @package Jhg\NexmoBundle\Model
 * @Author Javi Hernández
 */
class SmsSendResponse {

    /**
     * @var string
     */
    protected $to;

    /**
     * @var string
     */
    protected $messageId;

    /**
     * @var int
     */
    protected $status;

    /**
     * @var float
     */
    protected $remainingBalance;

    /**
     * @var float
     */
    protected $messagePrice;

    /**
     * @var int
     */
    protected $network;

    /**
     * @param stdClass $response
     * @return SmsSendResponse
     */
    public static function createFromResponse($response) {
        $smsSendResponse = new SmsSendResponse();

        $smsSendResponse->setTo($response['to']);
        $smsSendResponse->setMessageId($response['message-id']);
        $smsSendResponse->setStatus((int)$response['status']);
        $smsSendResponse->setRemainingBalance(floatval($response['remaining-balance']));
        $smsSendResponse->setMessagePrice(floatval($response['message-price']));
        $smsSendResponse->setNetwork((int)$response['network']);

        return $smsSendResponse;
    }



    /**
     * @param string $messageId
     */
    public function setMessageId($messageId)
    {
        $this->messageId = $messageId;
    }

    /**
     * @return string
     */
    public function getMessageId()
    {
        return $this->messageId;
    }

    /**
     * @param float $messagePrice
     */
    public function setMessagePrice($messagePrice)
    {
        $this->messagePrice = $messagePrice;
    }

    /**
     * @return float
     */
    public function getMessagePrice()
    {
        return $this->messagePrice;
    }

    /**
     * @param int $network
     */
    public function setNetwork($network)
    {
        $this->network = $network;
    }

    /**
     * @return int
     */
    public function getNetwork()
    {
        return $this->network;
    }

    /**
     * @param float $remainingBalance
     */
    public function setRemainingBalance($remainingBalance)
    {
        $this->remainingBalance = $remainingBalance;
    }

    /**
     * @return float
     */
    public function getRemainingBalance()
    {
        return $this->remainingBalance;
    }

    /**
     * @param int $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $to
     */
    public function setTo($to)
    {
        $this->to = $to;
    }

    /**
     * @return string
     */
    public function getTo()
    {
        return $this->to;
    }


} 