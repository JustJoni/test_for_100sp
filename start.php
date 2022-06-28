<?php

echo 'Скрипт запущен' . "\n";

require __DIR__ . '/vendor/autoload.php';

$app = new TestSolution\App(__DIR__ . DIRECTORY_SEPARATOR . '.env');

$app->run();

echo 'Окончание ' . date('d.m.Y H:i:s') . "\n";

