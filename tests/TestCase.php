<?php namespace Atxy2k\HappiPay\Tests;


use Atxy2k\HappiPay\HappiPay;
use Atxy2k\HappiPay\HappiPayServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            HappiPayServiceProvider::class
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'HappiPay' => HappiPay::class,
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

        $app['config']->set('happi_pay.endpoint', 'https://link.happipay.mx/generar');
        $app['config']->set('happi_pay.credentials.username', getenv('HAPPI_PAY_USERNAME'));
        $app['config']->set('happi_pay.credentials.password', getenv('HAPPI_PAY_PASSWORD'));

        $app['config']->set('happi_pay.options.tp', \Atxy2k\HappiPay\Constants\HappiPay::TP_UNA_SOLA_EXHIBICION);
        $app['config']->set('happi_pay.options.currency', \Atxy2k\HappiPay\Constants\HappiPay::MONEDA);
        $app['config']->set('happi_pay.options.notify_users', \Atxy2k\HappiPay\Constants\HappiPay::NO_NOTIFICAR_USUARIO);
        $app['config']->set('happi_pay.options.3ds', \Atxy2k\HappiPay\Constants\HappiPay::SEGURIDAD_CON_3DS);
        $app['config']->set('happi_pay.options.expiration_time', null);
        $app['config']->set('happi_pay.options.delegate_commissions', \Atxy2k\HappiPay\Constants\HappiPay::COMISION_TRANSFERIDA);
        $app['config']->set('happi_pay.options.concepts_limit', 5);
    }
}