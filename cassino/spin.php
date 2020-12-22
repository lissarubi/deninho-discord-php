<?php
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

function executeSpin($message)
{
    global $defaultEmoji;
    global $dbdata;
    global $players;

    $username = $message->author->user->username;
    $userIndex = getUser($username, $dbdata);

    //Verifica se a pessoa já está em um spin
    if (in_array($username, $players)) {
        $delete_value = $username;
        if (($key = array_search($delete_value, $players)) !== false) {
            unset($players[$key]);
        }
        $message->reply('Parabéns, é Spam <:pachic2Oo:764136010744332328>');
    } else {
        array_push($players, $username); // Adiciona a pessoa no array
        $messageSended = $message->channel
            ->sendMessage($defaultEmoji . $defaultEmoji . $defaultEmoji)
            ->then(function ($messageSended) use (
                $userIndex,
                $username,
                $players,
                $message
            ) {
                $sorted = generateSpin();
                global $defaultEmoji;
                global $dbdata;
                global $spinPoints;
                $messageSended->channel->editMessage(
                    $messageSended,
                    $sorted[0] . $defaultEmoji . $defaultEmoji
                );
                sleep(2);
                $messageSended->channel->editMessage(
                    $messageSended,
                    $sorted[0] . $sorted[1] . $defaultEmoji
                );
                sleep(2);
                $resultSpin = $sorted[0] . $sorted[1] . $sorted[2];
                $messageSended->channel->editMessage(
                    $messageSended,
                    $resultSpin
                );

                if ($sorted[0] == $sorted[1] && $sorted[1] == $sorted[2]) {
                    $message->reply(
                        'Parabéns! você ganhou um(a) ' . $sorted[0]
                    );
                    if ($userIndex != -1) {
                        $dbdata[$userIndex]['points'] += $spinPoints;
                        $dbdata[$userIndex]['plays'] += 1;

                        $userDB = $dbdata[$userIndex];
                        setPoints(
                            $userDB['name'],
                            $userDB['points'],
                            $userDB['plays']
                        );
                    } else {
                        array_push($dbdata, [
                            'name' => $username,
                            'points' => $spinPoints,
                            'plays' => 1,
                        ]);
                        createUser($username, $spinPoints);
                    }
                } else {
                    $message->reply('Parabéns! você perdeu');
                    if ($userIndex != -1) {
                        $dbdata[$userIndex]['plays'] += 1;

                        $userDB = $dbdata[$userIndex];
                        setPoints(
                            $userDB['name'],
                            $userDB['points'],
                            $userDB['plays']
                        );
                    } else {
                        array_push($dbdata, [
                            'name' => $username,
                            'points' => 0,
                            'plays' => 1,
                        ]);
                        createUser($username, 0);
                    }
                }
                $delete_value = $username;
                if (($key = array_search($delete_value, $players)) !== false) {
                    unset($players[$key]);
                }
            });
    }
}

function generateSpin()
{
    global $spinOptions;

    $sorted = [];

    for ($i = 0; $i < 3; $i++) {
        $index = array_rand($spinOptions, 1);
        array_push($sorted, $spinOptions[$index]);
    }

    return $sorted;
}
