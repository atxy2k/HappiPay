<?php

namespace Atxy2k\HappyPay;

use Atxy2k\HappyPay\Models\HappyPayRequest;
use Atxy2k\HappyPay\Models\HappyPayResponse;
use Exception;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use Throwable;

class HappyPay
{
    // Build wonderful things
    protected $username = null;
    protected $password = null;

    protected $url = null;

    public function __construct()
    {
        $this->url = config('happypay.endpoint');
        $this->username = config('happypay.credentials.username', null);
        $this->password = config('happypay.credentials.password', null);
    }

    public function getLink(HappyPayRequest $data) : HappyPayResponse
    {
        $response = HappyPayResponse::create();
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