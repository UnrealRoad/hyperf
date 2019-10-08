<?php

declare(strict_types = 1);

namespace App\Controller\Game;


class TestController extends BaseController
{

     public function test()
    {
        $this->server->push($this->frame->fd,'hello');
    }
}
