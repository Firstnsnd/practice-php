
<?php
/**
 * Created by PhpStorm.
 * User: vaniot
 * Date: 18-3-26
 * Time: 下午1:18
 */
$sock = socket_create(AF_INET, SOCK_STREAM, 0);

socket_bind($sock, "127.0.0.1", 8093);

socket_listen($sock);

$reads = [];
$clients = [];
$writes = NULL;
$exceptions = NULL;

socket_set_nonblock($sock);

$write_buffer = "HTTP/1.0 200 OK\r\nServer: my_server\r\nContent-Type: text/html; charset=utf-8\r\n\r\nhello!world";

for ( ; ; ) {

    $reads = array_merge(array($sock), $clients);

    $activity_counts = @socket_select($reads, $writes, $exceptions, 0);

    if ($activity_counts > 0) {

        if (($conn = socket_accept($sock)) !== false) {
            $clients[] = $conn;
        }


        $length = count($clients);
        for ($i = 0; $i < $length; $i++) {
            $client = $clients[$i];

            if (($read_buffer = @socket_read($client, 1024)) != false) {
                socket_write($client, $write_buffer);
                socket_close($client);
                break;
            }
        }

    }
}
