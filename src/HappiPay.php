<?php

namespace Atxy2k\HappiPay;

use Atxy2k\HappiPay\Models\HappiPayRequest;
use Atxy2k\HappiPay\Models\HappiPayResponse;
use Exception;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use Throwable;

class HappiPay
{
    // Build wonderful things
    protected $username = null;
    protected $password = null;

    protected $url = null;

    public function __construct()
    {
        $this->url = config('happi_pay.endpoint');
        $this->username = config('happi_pay.credentials.username', null);
        $this->password = config('happi_pay.credentials.password', null);
    }

    public function getLink(HappiPayRequest $data) : HappiPayResponse
    {
        $response = HappiPayResponse::create();
        try
        {
            /** @var Client $client */
            $client = new Client([ 'base_uri' => $this->url]);
            /** @var ResponseInterface $httpResponse */
            $httpResponse = $client->post($this->url, [
                'headers' => [
                    'Content-type' => 'application/x-www-form-urlencoded'
                ],
                'curl' => [
                    CURLOPT_HTTPHEADER => ['cache-control: no-cache'],
                    CURLOPT_USERPWD => vsprintf('%s:%s',[$this->username, $this->password]),
                    CURLOPT_RETURNTRANSFER => true
                ],
                'form_params' => $data->toArray()
            ]);
            throw_unless($httpResponse->getStatusCode() !== null,
                new Exception($httpResponse->getReasonPhrase()));
            $content = json_decode($httpResponse->getBody(), true);
            $response->withData($content);
        }
        catch (Throwable $e)
        {
            logger($e->getMessage());
            $response->setTitle('An error ocurred');
            $response->setMessage($e->getMessage());
        }
        return $response;
    }

}