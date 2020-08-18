<?php


namespace Atxy2k\HappiPay\Models;


use Atxy2k\HappiPay\Constants\HappiPay;
use Atxy2k\HappiPay\Constants\HappiPayParams;
use Atxy2k\HappiPay\Throws\ConceptCannotBeNullException;
use Atxy2k\HappiPay\Throws\ConceptsLimitReachedException;
use Atxy2k\HappiPay\Throws\InvalidPaymentType;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;

class HappiPayRequest implements Arrayable, Jsonable
{
    protected $amount = null;
    protected $ref = null;
    protected $currency = null;
    protected $tp = null;
    protected $notify = null;
    protected $security = null;
    protected $concepts = [];
    protected $description = null;
    protected $expiration_date = null;
    protected $commission = null;

    protected $concepts_limit = null;

    public function __construct(float $amount, string $ref)
    {
        $this->amount = $amount;
        $this->ref = $ref;
        $this->currency = config('happi_pay.options.currency', HappiPay::MONEDA);
        $this->tp = config('happi_pay.options.tp', HappiPay::TP_UNA_SOLA_EXHIBICION);
        $this->notify = config('happi_pay.options.tp', HappiPay::NO_NOTIFICAR_USUARIO);
        $this->security = config('happi_pay.options.3ds', HappiPay::SEGURIDAD_CON_3DS);
        $expiration_time = config('happi_pay.options.expiration_time', null);
        $this->commission = config('happi_pay.options.delegate_commissions', HappiPay::COMISION_TRANSFERIDA);
        $this->concepts_limit = config('happi_pay.options.concepts_limit', 5);
        if(!is_null($expiration_time) && is_numeric($expiration_time))
        {
            $expiration_date = now()->addMinutes($expiration_time)->format('Y-m-d');
            $this->expiration_date = $expiration_date;
        }
    }

    public static function create(float $amount, string $ref) : HappiPayRequest
    {
        return new HappiPayRequest($amount, $ref);
    }

    public function withCurrency(string $currency) : HappiPayRequest
    {
        $this->currency = $currency;
        return $this;
    }

    public function withTp($tp) : HappiPayRequest
    {
        throw_unless(in_array($tp, HappiPay::tp_disponibles()),
            InvalidPaymentType::class);
        $this->tp = $tp;
        return $this;
    }

    public function notifyUser(bool $notify) : HappiPayRequest
    {
        $this->notify = $notify ? HappiPay::NOTIFICAR_USUARIO : HappiPay::NO_NOTIFICAR_USUARIO;
        return $this;
    }

    public function with3ds() : HappiPayRequest
    {
        $this->security = HappiPay::SEGURIDAD_CON_3DS;
        return $this;
    }

    public function without3ds() : HappiPayRequest
    {
        $this->security = HappiPay::SEGURIDAD_SIN_3DS;
        return $this;
    }

    public function withDescription(string $description) : HappiPayRequest
    {
        $this->description = $description;
        return $this;
    }

    public function withExpirationDate(Carbon $carbon) : HappiPayRequest
    {
        $this->expiration_date = $carbon->format('Y-m-d');
        return $this;
    }

    public function deleteCommission() : HappiPayRequest
    {
        $this->commission = HappiPay::COMISION_TRANSFERIDA;
        return $this;
    }

    public function notDeleteCommission() : HappiPayRequest
    {
        $this->commission = HappiPay::COMISION_NO_TRANSFERIDA;
        return $this;
    }

    public function addConcept(HappiPayConcept $concept) : HappiPayRequest
    {
        throw_if(count($this->concepts) === $this->concepts_limit,
            ConceptsLimitReachedException::class);
        throw_if(is_null($concept), ConceptCannotBeNullException::class);
        $this->concepts[] = $concept;
        return $this;
    }

    public function toArray() : array
    {
        $data = [
            HappiPayParams::AMOUNT => $this->amount,
            HappiPayParams::REF => $this->ref,
            HappiPayParams::CURRENCY => $this->currency,
            HappiPayParams::TP => $this->tp,
            HappiPayParams::NOTIFY => $this->notify,
            HappiPayParams::SECURITY => $this->security,
            HappiPayParams::COMMISSION => $this->commission
        ];
        /**
         * @var int $key
         * @var HappiPayConcept $concept
         */
        foreach ($this->concepts as $key => $concept)
        {
            $d = $concept->withIndex($key+1)
                ->toArray();
            $data[$d['key']] = $d['value'];
        }
        if(!is_null($this->description))
        {
            $data[HappiPayParams::DESCRIPTION] = $this->description;
        }
        if(!is_null($this->expiration_date))
        {
            $data[HappiPayParams::EXPIRATION_DATE] = $this->expiration_date;
        }
        return $data;
    }

    public function toJson($options = 0) : string
    {
        return json_encode($this->toArray(), $options);
    }

}