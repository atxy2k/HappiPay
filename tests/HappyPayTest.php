<?php namespace Atxy2k\HappyPay\Tests;

use Atxy2k\HappyPay\HappyPay;
use Atxy2k\HappyPay\Models\HappyPayRequest;
use Atxy2k\HappyPay\Models\HappyPayResponse;
use Illuminate\Support\Str;

class HappyPayTest extends TestCase
{

    public function testCompleted()
    {
        $payment_id = Str::uuid()->toString();
        $payment = HappyPayRequest::create(100, $payment_id);
        $facade = new HappyPay();
        /** @var HappyPayResponse $response */
        $response = $facade->getLink($payment);
        $this->assertEquals(HappyPayResponse::COMPLETED, $response->getStatus());
    }

}