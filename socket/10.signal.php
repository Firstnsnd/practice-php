<?php
/**
 * Created by PhpStorm.
 * User: vaniot
 * Date: 18-3-26
 * Time: 下午1:46
 */
declare(ticks=1);

pcntl_signal(SIGINT, function() {
    file_put_contents("signal.txt", "signal recevied\n");
});

sleep(30);