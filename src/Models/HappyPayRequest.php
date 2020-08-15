<?php


namespace Atxy2k\HappyPay\Models;


use Atxy2k\HappyPay\Constants\HappyPay;
use Atxy2k\HappyPay\Constants\HappyPayParams;
use Atxy2k\HappyPay\Throws\ConceptCannotBeNullException;
use Atxy2k\HappyPay\Throws\ConceptsLimitReachedException;
use Atxy2k\HappyPay\Throws\InvalidPaymentType;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;

class HappyPayRequest implements Arrayable, Jsonable
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
        $this->currency = config('happypay.options.currency', HappyPay::MONEDA);
        $this->tp = config('happypay.options.tp', HappyPay::TP_UNA_SOLA_EXHIBICION);
        $this->notify = config('happypay.options.tp', HappyPay::NO_NOTIFICAR_USUARIO);
        $this->security = config('happypay.options.3ds', HappyPay::SEGURIDAD_CON_3DS);
        $expiration_time = config('happypay.options.expiration_time', null);
        $this->commission = config('happypay.options.delegate_commissions', HappyPay::COMISION_TRANSFERIDA);
        $this->concepts_limit = config('happypay.options.concepts_limit', 5);
        if(!is_null($expiration_time) && is_numeric($expiration_time))
        {
            $expiration_date = now()->addMinutes($expiration_time)->format('Y-m-d');
            $this->expiration_date = $expiration_date;
        }
    }

    public static function create(float $amount, string $ref) : HappyPayRequest
    {
        return new HappyPayRequest($amount, $ref);
    }

    public function withCurrency(string $currency) : HappyPayRequest
    {
        $this->currency = $currency;
        return $this;
    }

    public function withTp(int $tp) : HappyPayRequest
    {
        throw_unless(in_array($tp, HappyPay::tp_disponibles()),
            InvalidPaymentType::class);
        $this->tp = $tp;
        return $this;
    }

    public function notifyUser(bool $notify) : HappyPayRequest
    {
        $this->notify = $notify ? HappyPay::NOTIFICAR_USUARIO : HappyPay::NO_NOTIFICAR_USUARIO;
        return $this;
    }

    public function with3ds() : HappyPayRequest
    {
        $this->security = HappyPay::SEGURIDAD_CON_3DS;
        return $this;
    }

    public function without3ds() : HappyPayRequest
    {
        $this->security = HappyPay::SEGURIDAD_SIN_3DS;
        return $this;
    }

    public function withDescription(string $description) : HappyPayRequest
    {
        $this->description = $description;
        return $this;
    }

    public function withExpirationDate(Carbon $carbon) : HappyPayRequest
    {
        $this->expiration_date = $carbon->format('Y-m-d');
        return $this;
    }

    public function deleteCommission() : HappyPayRequest
    {
        $this->commission = HappyPay::COMISION_TRANSFERIDA;
        return $this;
    }

    public function notDeleteCommission() : HappyPayRequest
    {
        $this->commission = HappyPay::COMISION_NO_TRANSFERIDA;
        return $this;
    }

    public function addConcept(HappyPayConcept $concept) : HappyPayRequest
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
            HappyPayParams::AMOUNT => $this->amount,
            HappyPayParams::REF => $this->ref,
            HappyPayParams::CURRENCY => $this->currency,
            HappyPayParams::TP => $this->tp,
            HappyPayParams::NOTIFY => $this->notify,
            HappyPayParams::SECURITY => $this->security,
            HappyPayParams::COMMISSION => $this->commission
        ];
        /**
         * @var int $key
         * @var HappyPayConcept $concept
         */
        foreach ($this->concepts as $key => $concept)
        {
            $d = $concept->withIndex($key+1)
                ->toArray();
            $data[$d['key']] = $d['value'];
        }
        if(!is_null($this->description))
        {
            $data[HappyPayParams::DESCRIPTION] = $this->description;
        }
        if(!is_null($this->expiration_date))
        {
            $data[HappyPayParams::EXPIRATION_DATE] = $this->expiration_date;
        }
        return $data;
    }

    public function toJson($options = 0) : string
    {
        return json_encode($this->toArray(), $options);
    }

}