<?php
/**
 * User: 伍先生
 * DateTime: 2020/4/19 21:42
 * Class:  ${NAME}
 * Info:
 */


$http = new Swoole\Http\Server("127.0.0.1", 9090);
$http->on('request', function ($request, $response) {
    $response->end("<h1>Hello Swoole. #".rand(1000, 9999)."</h1>");
});
$http->start();