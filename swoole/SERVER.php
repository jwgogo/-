<?php
/**
 * User: 伍先生
 * DateTime: 2020/4/23 22:34
 * Class:  ${NAME}
 * Info:
 */

$http = new Swoole\Http\Server("0.0.0.0", 9502);

$http->on('request', function ($request, $response) {
    var_dump($request->get, $request->post);

});

$http->start();