<?php

declare(strict_types=1);

namespace Lovetrytry\Jichukuangjia;

use Hyperf\HttpMessage\Stream\SwooleStream;
use Lovetrytry\Jichukuangjia\Config;
use Lovetrytry\Jichukuangjia\Request;
use Lovetrytry\Jichukuangjia\Format\ClassEnum;
use Lovetrytry\Jichukuangjia\Format\FormatInterface;
use Psr\Http\Message\StreamInterface;

class Format
{
    /**
     * @var Config
     */
    protected $config;

    protected $class;

    protected $jsonOption;

    public function __construct()
    {
        $this->config = new Config;

        $this->class = $this->getClass();

        $this->checkJsonOption();
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

    public function checkJsonOption()
    {
        $calledAction = (new Request)->get("calledAction");

        if (in_array($calledAction["class"], $this->config->get("lovetrytry-jichukuangjia.format.jsonUnescapedSlashes"))) {
            $this->setJsonOption(JSON_UNESCAPED_SLASHES);
        }
    }

    public function setJsonOption($attribute)
    {
        $this->jsonOption = $attribute;

        return $this;
    }

    public function getJsonOption2Params()
    {
        return $this->jsonOption;
    }

    public function toStream(): StreamInterface
    {
        return new SwooleStream($this->toString());
    }

    public function toString(): string
    {
        return $this->__toString();
    }

    public function __toString(): string
    {
        if (empty($this->jsonOption)) {
            return (string) json_encode($this->toArray());
        }

        return (string) json_encode($this->toArray(), $this->getJsonOption2Params());
    }

    protected function getClass()
    {
        $className = $this->getClassName();

        if (is_null($className)) {
            return null;
        }

        $class = new $className(0);

        if ($class instanceof FormatInterface) {
            return $class;
        }

        return null;
    }

    protected function getClassName()
    {
        $default = $this->config->get("lovetrytry-jichukuangjia.format.default");

        if (class_exists($default)) {
            return $default;
        }

        $className = ClassEnum::get($default);

        if (class_exists($className)) {
            return $className;
        }

        return null;
    }
}
