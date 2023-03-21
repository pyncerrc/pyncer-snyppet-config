<?php
use Pyncer\Snyppet\Snyppet;
use Pyncer\Snyppet\SnyppetManager;

SnyppetManager::register(new Snyppet(
    'config',
    dirname(__DIR__),
    [
        'app' => ['Config']
    ],
));
