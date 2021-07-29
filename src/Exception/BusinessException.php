<?php

declare(strict_types=1);

namespace Lovetrytry\Jichukuangjia\Exception;


use Lovetrytry\Jichukuangjia\Constants\ErrorCodeMessage;
use Lovetrytry\Jichukuangjia\Format;
use Hyperf\Server\Exception\ServerException;
use Throwable;

/**
 * Exception for signaling runtime errors.
 *
 * @author     Xing Jiapeng
 */
class BusinessException extends ServerException
{
    /**
     * Constructs a new instance.
     *
     * @author     lovetrytry@yeah.net
     *
     * @param      int        $code      The code
     * @param      string     $message   The message
     * @param      Throwable  $previous  The previous
     */
    public function __construct(int $code = 0, string $message = null, Throwable $previous = null)
    {
        if (is_null($message)) {
            $message = ErrorCodeMessage($code);
        }

        $format = new Format;

        $format->setCode($code)
               ->setMsg($message);

        parent::__construct($format->toString(), $format->getStatusCode(), $previous);
        // parent::__construct($message, $code, $previous);
    }
}
