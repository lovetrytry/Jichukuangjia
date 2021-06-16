<?php

namespace Lovetrytry\Jichukuangjia\Format;

use \ArrayObject;
use Lovetrytry\Jichukuangjia\Exception\RuntimeException;

class CMD
{
    protected $code = 0;
    protected $data;
    protected $msg = "";

    public function __construct(int $code, $data = null, string $msg = "")
    {
        $this->code = (string) $code;
        $this->data = is_null($data) ? new ArrayObject : $data;
        $this->msg = $msg;
    }
    /**
     * [handle description]
     * @date   2021-05-31
     * @throw  \Exception
     * @return [type]     [description]
     */
    public function handle()
    {
        return [
            "code" => $this->code,
            "msg" => $this->msg,
            "data" => $this->data
        ];
    }
}
