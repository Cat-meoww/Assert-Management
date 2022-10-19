<?php

namespace App\Controllers;

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;


use App\Libraries\Chat;

class Server extends BaseController
{
    public function index()
    {
        echo "op";
    }
    public function start_server()
    {
        if (!is_cli()) {
            die;
        }

        $server = IoServer::factory(
            new HttpServer(
                new WsServer(
                    new Chat()
                )
            ),
            8055
        );

        $server->run();
    }
}
