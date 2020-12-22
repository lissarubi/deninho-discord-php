<?php

function generateRoll($message)
{
    global $dbdata;
    global $rollPoints;
    $randomNumber = rand(0, 95);
    $username = $message->author->user->username;
    $userIndex = getUser($username, $dbdata);

    if ($randomNumber >= 95) {
        $message->channel->sendMessage(
            'Você tirou ' . $randomNumber . ' Parabéns, Você ganhou!'
        );

        if ($userIndex != -1) {
            $userDB = $dbdata[$userIndex];

            $dbdata[$userIndex]['points'] += $rollPoints;
            $dbdata[$userIndex]['plays'] += 1;

            $userDB = $dbdata[$userIndex];

            setPoints($userDB['name'], $userDB['points'], $userDB['plays']);
        } else {
            array_push($dbdata, [
                'name' => $username,
                'points' => $rollPoints,
                'plays' => 1,
            ]);
            createUser($username, $rollPoints);
        }
    } else {
        $message->channel->sendMessage(
            'Você tirou ' . $randomNumber . ' Parabéns, você perdeu!'
        );
        if ($userIndex != -1) {
            $userDB = $dbdata[$userIndex];

            $dbdata[$userIndex]['plays'] += 1;

            $userDB = $dbdata[$userIndex];

            setPoints($userDB['name'], $userDB['points'], $userDB['plays']);
        } else {
            array_push($dbdata, [
                'name' => $username,
                'points' => 0,
                'plays' => 1,
            ]);
            createUser($username, 0);
        }
    }
}
