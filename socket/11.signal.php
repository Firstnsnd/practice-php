<?php
/**
 * Created by PhpStorm.
 * User: vaniot
 * Date: 18-3-26
 * Time: 下午1:48
 */
$event_base = new EventBase();

$event = new Event($event_base, SIGINT, Event::SIGNAL, function () use (&$event_base) {
    file_put_contents("signal2.txt", "signal recevied\n");
});

$event->add();

$event_base->loop();