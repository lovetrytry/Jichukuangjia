<?php

declare(strict_types=1);

namespace Lovetrytry\Jichukuangjia\Exception\Handler;

use Hyperf\Contract\StdoutLoggerInterface;
use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Psr\Http\Message\ResponseInterface;
use Throwable;

/**
 * Exception for signaling runtime errors.
 *
 * @author     Xing Jiapeng
 * @since      2021-06-01 16:32:48(+0800)
 */
class BaseExceptionHandler extends ExceptionHandler
{
    /**
     * @var StdoutLoggerInterface
     */
    protected $logger;

    public function __construct(StdoutLoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function handle(Throwable $throwable, ResponseInterface $response)
    {
        $this->logger->error(sprintf('%s[%s] in %s', $throwable->getMessage(), $throwable->getLine(), $throwable->getFile()));
        $this->logger->error($throwable->getTraceAsString());
        return $response->withHeader('Content-Type', 'application/json')
                        ->withStatus($throwable->getCode())
                        ->withBody(
                            new SwooleStream($throwable->getMessage())
                        );
    }

    public function isValid(Throwable $throwable): bool
    {
        return true;
    }
}