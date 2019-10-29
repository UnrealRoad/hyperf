<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://doc.hyperf.io
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf-cloud/hyperf/blob/master/LICENSE
 */

namespace App\Exception\Handler;

use App\Exception\ApiException;
use Hyperf\Contract\StdoutLoggerInterface;
use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Psr\Http\Message\ResponseInterface;
use Throwable;

class ApiExceptionHandler extends ExceptionHandler
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
        // 判断被捕获到的异常是希望被捕获的异常
        if ($throwable instanceof ApiException) {
            // 格式化输出
            $message = json_decode($throwable->getMessage(),true);

            $data = json_encode([
                'code' => $throwable->getCode(),
                'data' => is_array($message) || is_object($message) ? $message : [],
                'message' => $throwable->getMessage()
            ]);

            // 阻止异常冒泡
            $this->stopPropagation();
            return $response->withStatus($throwable->getCode())->withBody(new SwooleStream($data));
        }

        // 交给下一个异常处理器
        return $response;

    }

    public function isValid(Throwable $throwable): bool
    {
        return true;
    }
}
