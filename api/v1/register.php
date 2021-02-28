<?php
Header("Access-Control-Allow-Origin: http://host1.com");
Header("Access-Control-Allow-Credentials: true");
Header("Access-Control-Allow-Methods: POST");
Header("Access-Control-Allow-Headers: Content-Type");

require_once 'DataBase.php';
DataBase::createTableForUsers();

$login = "";
$pass = "";
getInputData($login, $pass);

if ($login !== 'users')
    echo json_encode(array('ok' => addUser($login, $pass)));
else
    echo json_encode(array('ok' => false));

/**
 * assigns values to passed variables from incoming data
 * @param $login - incoming username
 * @param $pass - incoming password
 */
function getInputData(&$login, &$pass)
{
    $inputData = file_get_contents('php://input')
    or die('error');

    $arr = json_decode($inputData, true);
    $login = $arr['login'];
    $pass = $arr['pass'];
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
    $pass = md5($pass);
    $query = "INSERT INTO `users`(`user`, `password`) VALUES ('$login','$pass')";
    return DataBase::executeRequest($query);;
}

