<?php

declare(strict_types=1);

namespace Jhg\NexmoBundle\NexmoClient;

use Jhg\NexmoBundle\NexmoClient\Exceptions\NexmoClientException;
use Jhg\NexmoBundle\NexmoClient\Exceptions\QuotaExcededException;
use Jhg\NexmoBundle\NexmoClient\Exceptions\UnroutableSmsMessageException;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

class NexmoClient
{
    private $rest_url;
    private $api_key;
    private $api_secret;
    private $api_method;
    private $delivery_phone;
    private $disable_delivery;
    private $logger;

    public function __construct(string $api_key, string $api_secret, ?string $delivery_phone, string $api_method = 'GET', bool $disable_delivery = false, ?LoggerInterface $logger = null)
    {
        $this->rest_url         = 'https://rest.nexmo.com';
        $this->api_key          = $api_key;
        $this->api_secret       = $api_secret;
        $this->api_method       = $api_method;
        $this->delivery_phone   = $delivery_phone;
        $this->disable_delivery = $disable_delivery;
        $this->logger           = $logger ?? new NullLogger();
    }

    /**
     * @param array<mixed> $params
     *
     * @return array<mixed>
     */
    protected function jsonRequest(string $url, array $params = []): array
    {
        $params['api_key']    = $this->api_key;
        $params['api_secret'] = $this->api_secret;

        $request_url = $this->rest_url.'/'.trim($url, '/').'?'.http_build_query($params);

        $request = curl_init($request_url);
        if($request === false) {
            throw new \RuntimeException("Can't initialize cURL object.");
        }
        curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($request, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($request, CURLOPT_HTTPHEADER, ['Accept: application/json']);

        $response           = (string) curl_exec($request);
        $curl_info          = curl_getinfo($request);
        $http_response_code = (int) $curl_info['http_code'];
        curl_close($request);

        switch ($http_response_code) {
            case 200:
                return json_decode($response, true);
        }

        return [];
    }

    /**
     * @return array<mixed>
     * @example {"autoReload":false,"value":0.2}
     *
     */
    public function accountBalance(): array
    {
        return $this->jsonRequest('/account/get-balance');
    }

    /**
     * @return array<mixed>
     * @example {"country":"ES","mt":0.060000,"name":"Spain","prefix":34}
     */
    public function accountSmsPrice(string $country): array
    {
        return $this->jsonRequest('/account/get-pricing/outbound', ['country' => $country]);
    }

    /**
     * @return array<mixed>
     *
     * @throws \Exception
     */
    public function sendTextMessage(string $fromName, string $toNumber, string $text, int $status_report_req = 0): array
    {
        $this->logger->debug("Nexmo sendTextMessage from $fromName to $toNumber with text '$text'");

        // delivery phone for development
        if ($this->delivery_phone !== null) {
            $toNumber = $this->delivery_phone;

            $this->logger->debug("Nexmo sendTextMessage delivery to $toNumber");
        }

        $params = [
            'from'              => $fromName,
            'to'                => $toNumber,
            'text'              => $text,
            'status-report-req' => $status_report_req,
        ];

        if ($this->disable_delivery) {
            $this->logger->debug('Nexmo sendTextMessage delivery disabled by config');

            return [
                'status'            => '0',
                'message-id'        => 'delivery-disabled',
                'to'                => $toNumber,
                'client-ref'        => 0,
                'remaining-balance' => 0,
                'message-price'     => 0,
                'network'           => 0,
            ];
        }

        $response = $this->jsonRequest('/sms/json', $params);

        if (0 !== $code = (int) $response['messages'][0]['status']) {
            $error = $response['messages'][0]['error-text'];
            switch ($code) {
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
