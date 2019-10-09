<?php

declare(strict_types = 1);

namespace App\Controller\Game;


class TestController extends BaseController
{



     public function test($data)
    {
        $this->push('test',$data);
    }
}
