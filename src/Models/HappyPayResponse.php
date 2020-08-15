<?php


namespace Atxy2k\HappyPay\Models;


use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class HappyPayResponse
{
    public const COMPLETED = 'success';
    public const FAIL = 'error';

    protected $status = self::FAIL;
    protected $title;
    protected $msg;
    protected $data;
    protected $id;
    protected $link;

    public function __construct(array $data = null)
    {
        if($data != null)
        {
            $this->withData($data);
        }
    }

    public function setTitle(string $title) : HappyPayResponse
    {
        $this->title = $title;
        return $this;
    }

    public function setMessage(string $msg) : HappyPayResponse
    {
        $this->msg = $msg;
        return $this;
    }

    public function withData(array $data) : HappyPayResponse
    {
        logger($data);
        $this->status = Arr::get($data,'status');
        $this->title = Arr::get($data, 'title', null);
        $this->msg = Arr::get($data,'msg', null);
        $this->data = [];
        $errors = Arr::get($data,'data', []);
        foreach ($errors as $error)
        {
            $this->data[] = $error['msg'];
        }
        $this->id = Arr::get($data, 'idLink', null);
        $this->link = Arr::get($data,'link', null);
        return $this;
    }

    public static function create(array $data = null) : HappyPayResponse
    {
        return new HappyPayResponse($data);
    }

    public function getStatus() : string
    {
        return $this->status;
    }

    public function getTitle() :?string
    {
        return $this->title;
    }

    public function getMessage() :?string
    {
        return $this->msg;
    }

    public function getErrorsData() : array
    {
        return $this->data;
    }

    public function getId() : ?string
    {
        return $this->id;
    }

    public function getLink() :?string
    {
        return $this->link;
    }

}