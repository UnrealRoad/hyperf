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

namespace App\Controller;

use Hyperf\HttpServer\Annotation\AutoController;

/**
 * Class IndexController
 * @package App\Controller
 * @AutoController()
 */
class IndexController extends AbstractController
{
    public function index()
    {
        $user = $this->request->input('user', 'Hyperf');
        $method = $this->request->getMethod();

        $header = [];
        $payload = [
            'user_id' => 1,
            'exp' => 1,
            'sub' => 'token'
        ];
        $a = base64_encode(json_encode($header));
        $b = base64_encode(json_encode($payload));
        $c = password_hash('asdasdrvbvbt43sfddfsdfsdf',PASSWORD_BCRYPT);
        $c1 = password_hash('asdasdrvbvbt43sfddfsdfsdf',PASSWORD_BCRYPT);
        if (hash_equals($c, crypt('asdasdrvbvbt43sfddfsdfsdf', $c))) {
            echo "Password verified!";
        }
        $test = base64_encode('asdasdrvbvbt43sfddfsdfsdf');
        return [
            'message' => $test,
            'c' => $c,
            'c1' => $c1
        ];
    }
}
