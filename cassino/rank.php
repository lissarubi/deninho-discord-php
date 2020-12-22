<?php

require 'utils/arraysort.php';

function generateRank($message)
{
    global $dbdata;

    $sortedUsers = array_sort($dbdata, 'points', SORT_DESC);

    $username = $message->author->user->username;
    $userIndex = getUser($username, $dbdata);

    $i = 0;
    $rankString = '';
    foreach ($sortedUsers as $user) {
        $rankString .=
            $i +
            1 .
            '° **' .
            $user['name'] .
            '** com **' .
            $user['points'] .
            '** pontos, jogando **' .
            $user['plays'] .
            '** vezes' .
            PHP_EOL;

        $i++;
    }

    if ($userIndex != -1) {
        $userDB = $dbdata[$userIndex];
        if ($userDB['points'] > 0) {
            $rankString .=
                PHP_EOL .
                'Enquanto você, ' .
                $userDB['name'] .
                ', Tem **' .
                $userDB['points'] .
                '** pontos, jogando **' .
                $userDB['plays'] .
                '** vezes';
        } else {
            $rankString .=
                PHP_EOL .
                'Enquanto você, ' .
                $userDB['name'] .
                ' precisa jogar mais vezes o cassino.';
        }
    }

    $message->channel->sendMessage($rankString);
}
