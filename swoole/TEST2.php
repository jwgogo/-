<?php
function decodeValue($data)
{
    return 256 * ord($data[0]) + ord($data[1]);
}

function decodeString($data)
{
    $length = decodeValue($data);
    return substr($data, 2, $length);
}

function mqttGetHeader($data)
{
    $byte = ord($data[0]);

    $header['type'] = ($byte & 0xF0) >> 4;
    $header['dup'] = ($byte & 0x08) >> 3;
    $header['qos'] = ($byte & 0x06) >> 1;
    $header['retain'] = $byte & 0x01;

    return $header;
}

function eventConnect($header, $data)
{
    $connect_info['protocol_name'] = decodeString($data);
    $offset = strlen($connect_info['protocol_name']) + 2;

    $connect_info['version'] = ord(substr($data, $offset, 1));
    $offset += 1;

    $byte = ord($data[$offset]);
    $connect_info['willRetain'] = ($byte & 0x20 == 0x20);
    $connect_info['willQos'] = ($byte & 0x18 >> 3);
    $connect_info['willFlag'] = ($byte & 0x04 == 0x04);
    $connect_info['cleanStart'] = ($byte & 0x02 == 0x02);
    $offset += 1;

    $connect_info['keepalive'] = decodeValue(substr($data, $offset, 2));
    $offset += 2;
    $connect_info['clientId'] = decodeString(substr($data, $offset));
    return $connect_info;
}

$server = new Swoole\Server("0.0.0.0", 9501, SWOOLE_BASE);

$server->set([
    'open_mqtt_protocol' => 1, // 启用 mqtt 协议
    'worker_num' => 1,
]);

$server->on('connect', function ($server, $fd) {
    echo "Client:Connect.\n";
});

$server->on('receive', function ($server, $fd, $from_id, $data) {

    echo "---------------------------------------------------- \n";
    echo "进程ID: $fd \n";
    echo "from_id: $from_id \n";
    echo "data: $data \n";
    $header = mqttGetHeader($data);
    echo "header: ".json_encode($header,256)." \n";

    if ($header['type'] == 1) {
        $resp = chr(32) . chr(2) . chr(0) . chr(0);
        eventConnect($header, substr($data, 2));
        $server->send($fd, $resp);
    } elseif ($header['type'] == 3) {
        $offset = 2;
        $topic = decodeString(substr($data, $offset));
        $offset += strlen($topic) + 2;
        $msg = substr($data, $offset);
        echo "client msg: $topic\n----------\n$msg\n";
        //file_put_contents(__DIR__.'/data.log', $data);
    }
    echo "received length=" . strlen($data) . "\n";
});

$server->on('close', function ($server, $fd) {
    echo "Client: Close.\n";
});

$server->start();
