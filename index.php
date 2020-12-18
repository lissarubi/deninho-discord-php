<?php

include 'config.php';
include __DIR__ . '/vendor/autoload.php';

use Discord\Discord;

$discord = new Discord([
    'token' => $TOKEN,
]);

$discord->on('ready', function ($discord) {
    echo "Bot is ready!", PHP_EOL;

    // Listen for messages.
    $discord->on('message', function ($message, $discord) {
        $command = explode(' ', $message->content);

        switch ($command[0]) {
            case '*hello':
                $message->reply('Hello World!');
                break;

            default:
                break;
        }
    });
});

$discord->run();
