<?php

require __DIR__ . '/vendor/autoload.php';
require 'config.php';
require 'cassino/db.php';

require 'cassino/spin.php';
require 'cassino/roll.php';
require 'cassino/rank.php';

$eitaCounter = 0;
$caraioCounter = 0;
$alfaCounter = 0;
$block = false;
$players = [];

$spinPoints = 100;
$rollPoints = 10;

$dbdata = readData();

$spinOptions = [
    '<:deninha:776790121399451718>',
    '<:patocorniopink:764155550941315084>',
    '<:jpbrab0EIsso:771852824715067412>',
    '<:pachic2Oo:764136010744332328>',
    '<:Kappa:775520055756324894>',
    '<:deninho:777326021007245323>',
    '<:D_:776935665081516092>',
];

$defaultEmoji = '<:KappaGolden:777234103543136256>';

use Discord\Discord;
use Discord\Parts\Channel\Channel;
use Discord\Parts\Channel\Message;

$discord = new Discord([
    'token' => $TOKEN,
]);

$discord->on('ready', function ($discord) {
    echo 'Bot is ready!', PHP_EOL;

    // Listen for messages.
    $discord->on('message', function (Message $message, Discord $discord) {
        global $players;
        $command = explode(' ', $message->content);
        $messageContent = strtolower($message->content);
        stringCommand($messageContent, $message);
        simpleCommand($command, $message);
    });
});

$discord->run();

function stringCommand($messageContent, $message)
{
    switch ($messageContent) {
        case 'bom dia':
            $message->reply('Bom Dia!');
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
}

function simpleCommand($command, $message)
{
    global $eitaCounter;
    global $caraioCounter;
    global $alfaCounter;
    global $dbdata;

    $prefix = '!';
    $commandCall = $command[0];
    switch ($commandCall) {
        case $prefix . 'eita':
            $eitaCounter++;
            $message->reply(
                'A Levxyca já falou eita ' . $eitaCounter . ' vezes'
            );
            break;
        case $prefix . 'caraio':
            $caraioCounter++;
            $message->reply(
                'A Pachi já falou caraio ' . $caraioCounter . ' vezes'
            );
            break;
        case $prefix . 'alfa':
            $alfaCounter++;
            $message->reply(
                ' já escutamos Panificadora Alfa ' . $alfaCounter . ' vezes'
            );
            break;
        case $prefix . 'splash':
            $message->reply('Splash Splash');
            break;
        case $prefix . 'cancelar':
            if (sizeof($command) != 2) {
                $message->reply(
                    'Vou te cancelar por ter mandado o comando errado!'
                );
            } else {
                $cancelamento = getCancelamento();
                $message->reply(
                    $command[1] . ' foi cancelado(a) por ' . $cancelamento
                );
            }
            break;
        case $prefix . 'amor':
            $message->reply(
                'Amor! <:pachiLuv:764154424754044979><:pachiLuv:764154424754044979><:pachiLuv:764154424754044979><:pachiLuv:764154424754044979><:pachiLuv:764154424754044979><:pachiLuv:764154424754044979>'
            );
            break;
        case $prefix . 'spin':
            if (
                str_contains($message->channel->name, 'teste-bot') ||
                str_contains($message->channel->name, 'spin')
            ) {
                executeSpin($message);
            }
            break;
        case $prefix . 'roll':
            if (
                str_contains($message->channel->name, 'teste-bot') ||
                str_contains($message->channel->name, 'roll')
            ) {
                generateRoll($message);
            }
            break;
        case $prefix . 'ranking':
            if (
                str_contains($message->channel->name, 'teste-bot') ||
                str_contains($message->channel->name, 'roll') ||
                str_contains($message->channel->name, 'spin')
            ) {
                generateRank($message);
            }
    }
}

function getCancelamento()
{
    $handle = fopen('cancelamentos.txt', 'r');
    $contents = fread($handle, filesize('cancelamentos.txt'));
    fclose($handle);

    $cancelamentos = explode("\n", $contents);

    $index = array_rand($cancelamentos, 1);
    return $cancelamentos[$index];
}
