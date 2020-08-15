<?php namespace Atxy2k\HappyPay\Tests;


use Atxy2k\HappyPay\HappyPay;
use Atxy2k\HappyPay\HappyPayServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            HappyPayServiceProvider::class
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'HappyPay' => HappyPay::class,
        ];
    }

    protected function getApplicationTimezone($app)
    {
        return 'America/Merida';
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('app.key', 'base64:zQYJdPhBgACWDjjOIdUiBsQq6z07GzX6BfFvzPiijaM=');
        $app['config']->set('app.url', 'http://essence.test');
        $app['config']->set('logging.default', 'stack');
        $app['config']->set('logging.channels.single.path', __DIR__.'/../logs/laravel.log');

        $app['config']->set('happypay.endpoint', 'https://link.happipay.mx/generar');
        $app['config']->set('happypay.credentials.username', getenv('HAPPY_PAY_USERNAME'));
        $app['config']->set('happypay.credentials.password', getenv('HAPPY_PAY_PASSWORD'));

        $app['config']->set('happypay.options.tp', \Atxy2k\HappyPay\Constants\HappyPay::TP_UNA_SOLA_EXHIBICION);
        $app['config']->set('happypay.options.currency', \Atxy2k\HappyPay\Constants\HappyPay::MONEDA);
        $app['config']->set('happypay.options.notify_users', \Atxy2k\HappyPay\Constants\HappyPay::NO_NOTIFICAR_USUARIO);
        $app['config']->set('happypay.options.3ds', \Atxy2k\HappyPay\Constants\HappyPay::SEGURIDAD_CON_3DS);
        $app['config']->set('happypay.options.expiration_time', null);
        $app['config']->set('happypay.options.delegate_commissions', \Atxy2k\HappyPay\Constants\HappyPay::COMISION_TRANSFERIDA);
        $app['config']->set('happypay.options.concepts_limit', 5);
    }
}