<?php

$dsn = 'mysql:host=localhost;dbname=cassino';

$db = new PDO($dsn, $USERDB, $PASSWD);

function readData()
{
  global $db;
  $stmt = $db->prepare('SELECT * FROM points');
  $stmt->execute();
  $data = [];
  while ($row = $stmt->fetch()) {
    array_push($data, $row);
  }
  return $data;
}

function createUser($name, $points)
{
  global $db;
  try{

    $stmt = $db->prepare(
      'INSERT INTO points (name, points, plays) VALUES (:name, :points, 1)'
    );
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':points', $points);
    return $stmt->execute();
  }catch(Exception $err){
    print_r($err);
  }

}

function setPoints($name, $points, $plays)
{
  global $db;
  $stmt = $db->prepare(
    'UPDATE points SET points=:points, plays=:plays WHERE name=:name'
  );

  $stmt->bindParam(':points', $points);
  $stmt->bindParam(':plays', $plays);
  $stmt->bindParam(':name', $name);

  $stmt->execute();
}

function getUser($username, $dbdata)
{
  $i = 0;
  foreach ($dbdata as $user) {
    if ($user['name'] == $username) {
      return $i;
    }
    $i++;
  }
  return -1;
}
