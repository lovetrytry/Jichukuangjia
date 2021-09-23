<?php

namespace Lovetrytry\Jichukuangjia\Format;

use Lovetrytry\Jichukuangjia\Config;
use Lovetrytry\Jichukuangjia\Constants\ErrorCode;
use Lovetrytry\Jichukuangjia\Exception\BusinessException;
use Lovetrytry\Jichukuangjia\Validation\InterfaceResponse;

class CMD implements FormatInterface
{
    protected $codeKey = "code";
    protected $msgKey = "msg";
    protected $dataKey = "data";

    protected $code = 0;
    protected $msg = "";
    protected $data;

    /**
     * @var Config
     */
    protected $config;

    public function __construct($code, $data = null, string $msg = "")
    {

        $this->config = new Config;

        $this->setCodeKey();
        $this->setMsgKey();
        $this->setDataKey();

        $this->setCode($code);
        $this->setData($data);
        $this->setMsg($msg);
    }

    public function setCode($code)
    {
        if ($code === 0) {
            $code = 200000;
        } elseif ($code === 1) {
            $code = 500000;
        }

        $this->code = $code;

        return $this;
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

    public function getCode()
    {
        return (string) $this->code;
    }

    public function getStatusCode()
    {
        $code = (int) $this->getCode();

        if ($code > 99 && $code < 600) {
            return $code;
        }

        if ($code < 99 || $code > 999999) {
            return 500;
        }

        return (int) substr($code, 0, 3);
    }

    public function getMsg()
    {
        return $this->msg;
    }

    public function getData()
    {
        return $this->data;
    }

    /**
     * @return [type]     [description]
     */
    public function toArray(): array
    {
        return [
            $this->getCodeKey() => $this->getCode(),
            $this->getMsgKey() => $this->getMsg(),
            $this->getDataKey() => $this->getData()
        ];
    }

    public function getCodeKey()
    {
        return $this->codeKey;
    }

    public function getMsgKey()
    {
        return $this->msgKey;
    }

    public function getDataKey()
    {
        return $this->dataKey;
    }

    protected function setCodeKey()
    {
        $this->setKey("code");
    }

    protected function setMsgKey()
    {
        $this->setKey("msg");
    }

    protected function setDataKey()
    {
        $this->setKey("data");
    }

    protected function setKey($key)
    {
        $value = $this->config->get("lovetrytry-jichukuangjia.format.keys.{$key}");

        if (! empty($value)) {
            $vKey = $key . 'Key';

            $this->$vKey = $value;
        }
    }

    protected function handleData()
    {
        if ($this->config->get("lovetrytry-jichukuangjia.format.apiResponseCheck")) {
            $interfaceResponse = new InterfaceResponse($this->toArray());

            if (is_null($this->data)) {
                $this->data = $interfaceResponse->getDefaultData($this->dataKey);

                return;
            }

            $interfaceResponseCheck = $interfaceResponse->handle();

            if (! $interfaceResponseCheck) {
                throw new BusinessException(ErrorCode::SERVER_ERROR, "接口响应结构与文档不符，请检查。");
            }
        }
    }
}
