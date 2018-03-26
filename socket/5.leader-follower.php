<?php
/**
 * Created by PhpStorm.
 * User: vaniot
 * Date: 18-3-26
 * Time: 下午12:30
 */
$sock = stream_socket_server("tcp://127.0.0.1:8093", $errno, $errstr);

$pids = [];

for ($i=0; $i<10; $i++) {

    $pid = pcntl_fork();
    $pids[] = $pid;

    if ($pid == 0) {
        for ( ; ; ) {
            $conn = stream_socket_accept($sock);

            $write_buffer = "HTTP/1.0 200 OK\r\nServer: my_server\r\nContent-Type: text/html; charset=utf-8\r\n\r\nhello!world";

            fwrite($conn, $write_buffer);

            fclose($conn);
        }

        exit(0);
    }

}

foreach ($pids as $pid) {
    pcntl_waitpid($pid, $status);
}
