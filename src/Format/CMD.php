<?php

namespace Lovetrytry\Jichukuangjia\Format;

use \ArrayObject;
use \Exception;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Lovetrytry\Jichukuangjia\Exception\BusinessException;
use Lovetrytry\Jichukuangjia\Validation\InterfaceResponse;
use Psr\Http\Message\StreamInterface;

class CMD implements FormatInterface
{
    protected $codeKey = "code";
    protected $msgKey = "msg";
    protected $dataKey = "data";

    protected $code = 0;
    protected $msg = "";
    protected $data;

    public function __construct(int $code, $data = null, string $msg = "")
    {
        $this->setCode($code);
        $this->setData($data);
        $this->setMsg($msg);
    }

    public function setCode(int $code)
    {
        if ($code === 0) {
            $code = 200000;
        } elseif ($code === 1) {
            $code = 500000;
        }

        $this->code = (string) $code;

        return $this;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function getStatusCode()
    {

    }

    public function getData()
    {
        return $this->data;
    }

    public function setMsg(string $msg)
    {
        $this->msg = $msg;

        return $this;
    }

    public function setData($data = null)
    {
        $this->data = $data;

        $this->handleData();

        return $this;
    }

    /**
     * @return [type]     [description]
     */
    public function toArray(): array
    {
        return [
            $this->codeKey => $this->code,
            $this->msgKey => $this->msg,
            $this->dataKey => $this->data
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

    protected function handleData()
    {
        $interfaceResponse = new InterfaceResponse($this->toArray());

        if (is_null($this->data)) {
            $this->data = $interfaceResponse->getDefaultData($this->dataKey);
        } else {
            $interfaceResponseCheck = $interfaceResponse->handle();

            if (! $interfaceResponseCheck) {
                throw new BusinessException(500, "接口响应结构与文档不符，请检查。");
            }
        }
    }
}
