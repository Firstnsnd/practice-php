<?php
/**
 * Created by PhpStorm.
 * User: vaniot
 * Date: 18-3-26
 * Time: 下午1:38
 */
function daemon() {
    umask(0);

    if (pcntl_fork()) {
        exit(0);
    }

    posix_setsid();

    if (pcntl_fork()) {
        exit(0);
    }

    sleep(100);
}

daemon();