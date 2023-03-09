<?php
use Pyncer\Snyppet\SnyppetManager;
use Pyncer\Snyppet\Snyppet;

SnyppetManager::register(new Snyppet(
    'config',
    dirname(__DIR__),
    [
        'app' => ['Config']
    ],
));
