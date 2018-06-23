<?php
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

require dirname(__DIR__) . '/vendor/autoload.php';

PSDE\Server::initialize();
$loop = \React\EventLoop\Factory::create();
$socket = new \React\Socket\Server('0.0.0.0:1029', $loop);

$server = new IoServer(
    new HttpServer(
        new WsServer(
            PSDE\Server::$messageListener
        )
    ),
    $socket,
    $loop
);

$loop->addPeriodicTimer(0.03, function () {
	if (PSDE\Server::$positionsChanged) {
	    PSDE\Server::broadcastPlayerLocRots();
	    PSDE\Server::$positionsChanged = false;
	}
});

$server->run();
