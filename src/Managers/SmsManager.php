<?php

declare(strict_types=1);

namespace Jhg\NexmoBundle\Managers;

use Jhg\NexmoBundle\Model\SmsSendResponse;
use Jhg\NexmoBundle\NexmoClient\NexmoClient;
use Jhg\NexmoBundle\Utils\PhoneNumber;

/**
 * Class SmsManager
 *
 * @Author Javi Hernández
 */
class SmsManager
{
    private $nexmoClient;
    private $defaultFromName;

    public function __construct(NexmoClient $nexmoClient, string $defaultFromName)
    {
        $this->nexmoClient     = $nexmoClient;
        $this->defaultFromName = $defaultFromName;
    }

    public function sendText(string $number, string $message, ?string $fromName = null, int $status_report_req = 0): SmsSendResponse
    {
        $fromName = null !== $fromName ? $fromName : $this->defaultFromName;
        $number   = PhoneNumber::prefixFilter($number);
        $response = $this->nexmoClient->sendTextMessage($fromName, $number, $message, $status_report_req);

        return SmsSendResponse::createFromResponse($response);
    }

    public function sendBinary(): void
    {
        throw new \Exception(__METHOD__.' not yet implemented');
    }

    public function sendWapPush(): void
    {
        throw new \Exception(__METHOD__.' not yet implemented');
    }

    public function searchMessage(): void
    {
        throw new \Exception(__METHOD__.' not yet implemented');
    }

    public function searchMessages(): void
    {
        throw new \Exception(__METHOD__.' not yet implemented');
    }

    public function searchRejections(): void
    {
        throw new \Exception(__METHOD__.' not yet implemented');
    }
}
