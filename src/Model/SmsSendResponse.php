<?php

declare(strict_types=1);

namespace Jhg\NexmoBundle\Model;


/**
 * Class SmsSendResponse
 *
 * @Author Javi Hernández
 */
class SmsSendResponse
{
    /**
     * @var string
     */
    private $to;

    /**
     * @var string
     */
    private $messageId;

    /**
     * @var int
     */
    private $status;

    /**
     * @var float
     */
    private $remainingBalance;

    /**
     * @var float
     */
    private $messagePrice;

    /**
     * @var int
     */
    private $network;

    /**
     * @param array<mixed> $response
     */
    public static function createFromResponse(array $response): self
    {
        $smsSendResponse = new self();

        $smsSendResponse->setTo($response['to']);
        $smsSendResponse->setMessageId($response['message-id']);
        $smsSendResponse->setStatus((int) $response['status']);
        $smsSendResponse->setRemainingBalance(floatval($response['remaining-balance']));
        $smsSendResponse->setMessagePrice(floatval($response['message-price']));
        $smsSendResponse->setNetwork((int) $response['network']);

        return $smsSendResponse;
    }

    public function getTo(): string
    {
        return $this->to;
    }

    public function setTo(string $to): void
    {
        $this->to = $to;
    }

    public function getMessageId(): string
    {
        return $this->messageId;
    }

    public function setMessageId(string $messageId): void
    {
        $this->messageId = $messageId;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function setStatus(int $status): void
    {
        $this->status = $status;
    }

    public function getRemainingBalance(): float
    {
        return $this->remainingBalance;
    }

    public function setRemainingBalance(float $remainingBalance): void
    {
        $this->remainingBalance = $remainingBalance;
    }

    public function getMessagePrice(): float
    {
        return $this->messagePrice;
    }

    public function setMessagePrice(float $messagePrice): void
    {
        $this->messagePrice = $messagePrice;
    }

    public function getNetwork(): int
    {
        return $this->network;
    }

    public function setNetwork(int $network): void
    {
        $this->network = $network;
    }
}
