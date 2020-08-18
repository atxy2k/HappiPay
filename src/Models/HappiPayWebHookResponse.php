<?php


namespace Atxy2k\HappiPay\Models;


use Carbon\Carbon;
use Illuminate\Support\Arr;

class HappiPayWebHookResponse
{
    public const APPROVED = 'approved';
    public const ERROR = 'error';

    /** @var string $reference Idenfificador propio del pago  */
    protected $reference = null;
    /** @var string $response  */
    protected $response = null;
    /** @var string $id Id de la liga creada */
    protected $id = null;
    /** @var string Folio único del pago */
    protected $folio = null;
    /** @var string Número de autorización de pago */
    protected $auth = null;
    /** @var string Mostrará un número cuando el pago marque error */
    protected $error = null;
    /** @var string Hora en que se realizó el cargo */
    protected $time = null;
    /** @var string Fecha en que se realizó el cargo */
    protected $date = null;
    /** @var string Tipo de pago */
    protected $tp = null;
    /** @var string Tipo de tarjeta */
    protected $cc_type = null;
    /** @var string Tipo de transacción realizada */
    protected $tp_operation = null;
    /** @var string Nombre del tarjeta habiente */
    protected $cc_name = null;
    /** @var string Ultimos 4 números de la tarjeta */
    protected $cc_number = null;
    /** @var string Més de expiración de la tarjeta */
    protected $cc_exp_month = null;
    /** @var string Año de expiración de la tarjeta */
    protected $cc_exp_year = null;
    /** @var double Cantidad pagada */
    protected $amount = null;
    /** @var string Descripción de la liga generada */
    protected $description = null;
    /** @var array Detalles de la liga generada */
    protected $details = [];

    public function __construct(array $data = null)
    {
        if(!is_null($data))
        {
            $this->withData($data);
        }
    }

    public static function create(array $data = null) : HappiPayWebHookResponse
    {
        return new HappiPayWebHookResponse($data);
    }

    public function withData(array $data) : HappiPayWebHookResponse
    {
        $this->reference = Arr::get($data,'referencia');
        $this->response = Arr::get($data,'response');
        $this->id = Arr::get($data,'id');
        $this->folio = Arr::get($data,'foliocpagos');
        $this->auth = Arr::get($data,'auth');
        $this->error = Arr::get($data,'nb_error');
        $this->time = Arr::get($data, 'hora');
        $this->date = Arr::get($data,'fecha');
        $this->tp = Arr::get($data,'tipo_pago');
        $this->cc_type = Arr::get($data,'cc_type');
        $this->tp_operation = Arr::get($data,'tp_operation');
        $this->cc_name = Arr::get($data,'cc_name');
        $this->cc_number = Arr::get($data,'cc_number');
        $this->cc_exp_month = Arr::get($data,'cc_expmonth');
        $this->cc_exp_year = Arr::get($data,'cc_expyear');
        $this->amount = Arr::get($data,'amount');
        $this->description = Arr::get($data,'descripcion');
        $current_details = Arr::get($data, 'detalles', []);
        $this->details = [];
        foreach ($current_details as $info)
        {
            $this->details[] = HappiPayConcept::create($info['label'], $info['value']);
        }
        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function getResponse() : ?string
    {
        return $this->response;
    }

    public function getId() : ?string
    {
        return $this->id;
    }

    public function getFolio() :?string
    {
        return $this->folio;
    }

    /**
     * @return string
     */
    public function getAuth(): string
    {
        return $this->auth;
    }

    /**
     * @return string
     */
    public function getError(): string
    {
        return $this->error;
    }

    /**
     * @return string
     */
    public function getTime(): string
    {
        return $this->time;
    }

    /**
     * @return string
     */
    public function getDate(): string
    {
        return $this->date;
    }

    public function getFullDate() :?Carbon
    {
        $return = null;
        if(!is_null($this->date) && !is_null($this->time))
        {
            $return = Carbon::createFromFormat('Y-m-d H:i:s', vsprintf('%s %s', [
                $this->date,
                $this->time
            ]));
        }
        return $return;
    }

    /**
     * @return string
     */
    public function getTp(): string
    {
        return $this->tp;
    }

    /**
     * @return string
     */
    public function getCcType(): string
    {
        return $this->cc_type;
    }

    /**
     * @return string
     */
    public function getTpOperation(): string
    {
        return $this->tp_operation;
    }

    /**
     * @return string
     */
    public function getCcName(): string
    {
        return $this->cc_name;
    }

    /**
     * @return string
     */
    public function getCcNumber(): string
    {
        return $this->cc_number;
    }

    /**
     * @return string
     */
    public function getCcExpMonth(): string
    {
        return $this->cc_exp_month;
    }

    /**
     * @return string
     */
    public function getCcExpYear(): string
    {
        return $this->cc_exp_year;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return array
     */
    public function getDetails(): array
    {
        return $this->details;
    }
    
    
}