<?php

declare(strict_types=1);

namespace App\Controller\Blog;

use App\Model\Blog;
use App\Request\BlogRequest;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;

class BlogController extends BaseController
{
    public function index(RequestInterface $request, ResponseInterface $response)
    {
        $data = Blog::paginate(15);
        return success($data);
    }

    public function store(BlogRequest $request)
    {

        $data = $request->validated();

        return Blog::create($data) ? success() : fail();
    }
}
