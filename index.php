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
        $command = strtolower($message->content);

        switch ($command) {
            case 'bom dia':
                $message->reply('Bom Dia!');
                break;
            case 'boa tarde':
                $message->reply('Boa Tarde!');
                break;
            case 'boa noite':
                $message->reply('Boa Noite!');
                break;
            case 'boas festas':
                $message->reply('Boas Festas!');
                break;
            default:
                break;
        }

        $command = explode(' ', $command);

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
