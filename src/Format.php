<?php

declare(strict_types=1);

namespace Lovetrytry\Jichukuangjia;

use Lovetrytry\Jichukuangjia\Config;
use Lovetrytry\Jichukuangjia\Format\ClassEnum;

class Format
{
    /**
     * @var Config
     */
    protected $config;

    protected $class;

    public function __construct()
    {
        $this->config = new Config;

        $class = $this->getClassName();

        $this->class = new $class(0);
    }

    public function __call($name, $arguments)
    {
        return $this->class->{$name}(...$arguments);
    }

    public function getContent($content)
    {
        $deContent = json_decode($content, true);

        if (is_null($deContent)) {
            return $content;
        }

        return $deContent;
    }

    protected function getClassName()
    {
        $default = $this->config->get("lovetrytry-jichukuangjia.format.default");

        $className = ClassEnum::get($default);

        if (class_exists($className)) {
            return $className;
        }

        throw new Exception("Format ${className} 不存在", 500);
    }
}
