<?php namespace Atxy2k\HappiPay\Tests;

use Atxy2k\HappiPay\HappiPay;
use Atxy2k\HappiPay\Models\HappiPayRequest;
use Atxy2k\HappiPay\Models\HappiPayResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class HappiPayTest extends TestCase
{

    public function testCompleted()
    {
        $payment_id = Str::uuid()->toString();
        $payment = HappiPayRequest::create(100, $payment_id);
        $facade = new HappiPay();
        /** @var HappiPayResponse $response */
        $response = $facade->getLink($payment);
        $this->assertEquals(HappiPayResponse::COMPLETED, $response->getStatus());

        $jsonStringResponse = json_encode($response);
        $this->assertNotNull($jsonStringResponse);
        $this->assertTrue(strlen($jsonStringResponse) > 0);

        $original_object = json_decode($jsonStringResponse, true);
        $this->assertNotNull($original_object);
        $this->assertIsArray($original_object);
        $this->assertNotNull( Arr::get($original_object, 'status') );
    }

}