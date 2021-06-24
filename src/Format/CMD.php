<?php

namespace Lovetrytry\Jichukuangjia\Format;

use \ArrayObject;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Lovetrytry\Jichukuangjia\Exception\RuntimeException;
use Psr\Http\Message\StreamInterface;

class CMD implements FormatInterface
{
    protected $code = 0;
    protected $data;
    protected $msg = "";

    public function __construct(int $code, $data = null, string $msg = "")
    {
        $this->setCode($code);
        $this->setData($data);
        $this->setMsg($msg);
    }

    public function setCode(int $code)
    {
        if ($code === 0) {
            $code = 200;
        } elseif ($code === 1) {
            $code = 500;
        }

        $this->code = (string) $code;

        return $this;
    }

    public function getCode()
    {
    }

    public function getStatusCode()
    {

    }

    public function setMsg(string $msg)
    {
        $this->msg = $msg;

        return $this;
    }

    public function setData($data = null)
    {
        $this->data = is_null($data) ? new ArrayObject : $data;
    }

    /**
     * @return [type]     [description]
     */
    public function toArray(): array
    {
        return [
            "code" => $this->code,
            "msg" => $this->msg,
            "data" => $this->data
        ];
    }

    public function toStream(): StreamInterface
    {
        return new SwooleStream((String) $this);
    }

    public function toString(): string
    {
        return $this->__toString();
    }

    public function __toString(): string
    {
        return (string) json_encode($this->toArray());
    }
}
