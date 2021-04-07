<?php

declare(strict_types = 1);

namespace Lovetrytry\Jichukuangjia;

use Lovetrytry\Jichukuangjia\Match;

/**
 * @author lovetrytry
 * @email lovetrytry@yeah.net
 */
class Base
{

    public function __construct(array $attributes = [])
    {
    }

    /**
     * Handle dynamic static method calls into the method.
     *
     * @author lovetrytry
     * @date   2021-03-31
     * @throw  \Exception
     * @param  [type]     $method     [description]
     * @param  [type]     $parameters [description]
     * @return [type]                 [description]
     */
    public static function __callStatic($method, $parameters)
    {
        return (new static())->{$method}(...$parameters);
    }
}
