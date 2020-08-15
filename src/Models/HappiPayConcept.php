<?php


namespace Atxy2k\HappiPay\Models;


use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;

class HappiPayConcept implements Arrayable
{
    protected $title;
    protected $value;
    protected $index = 1;

    /**
     * HappyPayConcept constructor.
     * @param $title
     * @param $value
     */
    public function __construct($title, $value)
    {
        $this->title = $title;
        $this->value = $value;
    }

    public static function create(string $title, string $value) : HappiPayConcept
    {
        return new HappiPayConcept($title, $value);
    }

    public function withTitle(string $title) : HappiPayConcept
    {
        $this->title = $title;
        return $this;
    }

    public function withValue(string $value) : HappiPayConcept
    {
        $this->value = $value;
        return $this;
    }

    public function withIndex(int $index) : HappiPayConcept
    {
        $this->index = $index;
        return $this;
    }

    public function toArray()
    {
        $key = vsprintf('d%dl', [$this->index]);
        $value = vsprintf('d%dv', [$this->index]);
        return [ 'key' => $key, 'value' => $value ];
    }

}