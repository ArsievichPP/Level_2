<?php
Header("Access-Control-Allow-Origin: http://host2.com");
Header("Access-Control-Allow-Credentials: true");
Header("Access-Control-Allow-Methods: POST");
Header("Access-Control-Allow-Headers: Content-Type");

require_once 'DataBase.php';
DataBase::createTableForUsers();
DataBase::createTableForItems();

$login = "";
$pass = "";
getInputData($login, $pass);

echo json_encode(array('ok' => addUser($login, $pass)));


/**
 * assigns values to passed variables from incoming data
 * @param $login - incoming username
 * @param $pass - incoming password
 */
function getInputData(&$login, &$pass)
{
    $inputData = json_decode(file_get_contents('php://input'), true);
    $login = $inputData['login'];
    $pass = $inputData['pass'];
}

/**
 * adds a user to the database and returns true if successful, otherwise false
 * @param $login - of new user
 * @param $pass - of new user
 * @return bool
 */
function addUser($login, $pass)
{
    require_once 'DataBase.php';
    $db = DataBase::connectDB();
    $query = $db->prepare("INSERT INTO `users`(`login`, `password`) VALUES (?, ?)");
    return $query->execute(array($login, md5($pass)));
}

