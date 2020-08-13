<?php
declare(strict_types=1);

use Swoole\WebSocket\Server;
use Swoole\Http\Request;
use Swoole\WebSocket\Frame;

$server = new Server("0.0.0.0", 9502);

$server->on("start", function (Server $server) {
	echo "Swoole WebSocket Server is started at http://127.0.0.1:9502\n";
});

$server->on('open', function (Server $server, Swoole\Http\Request $request) {
	echo "connection open: {$request->fd}\n";
//	$server->tick(10000, function () use ($server, $request) {
//		$server->push($request->fd, json_encode(["hello", time()]));
//	});
});

$server->on('message', function (Server $server, Frame $frame) {
	echo "received message: {$frame->data}\n";
	$server->push($frame->fd, '{"alert": "Hello from PHP"}');
});

$server->on('close', function (Server $server, int $fd) {
	echo "connection close: {$fd}\n";
});

$server->start();
