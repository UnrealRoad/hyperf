<?php

declare(strict_types=1);

namespace App\Controller\Blog;

use Hyperf\HttpServer\Annotation\AutoController;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;

/**
 * Class HomeController
 * @package App\Controller\Blog
 * @AutoController()
 */
class HomeController
{
    public function index(RequestInterface $request, ResponseInterface $response)
    {
        return $response->raw('Hello Hyperf!');
    }

    public function test()
    {
        return success();
    }
}
