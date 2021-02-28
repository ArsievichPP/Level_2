<?php
Header("Access-Control-Allow-Origin: http://host1.com");
Header("Access-Control-Allow-Credentials: true");
Header("Access-Control-Allow-Methods: POST");
Header("Access-Control-Allow-Headers: Content-Type");
session_start();
$inputLogin = "";
$inputPass = "";
getInputData($inputLogin, $inputPass);
$truePass = getPassFor($inputLogin);

if (md5($inputPass) === $truePass){
    require_once 'DataBase.php';
    DataBase::createTableForItems($inputLogin);
    $_SESSION['login'] = "$inputLogin";
    echo json_encode(array('ok' => true));
}

/**
 * assigns values to passed variables from incoming data
 * @param $login - incoming username
 * @param $pass - incoming password
 */
function getInputData(&$login, &$pass) {
    $inputData = file_get_contents('php://input')
        or die('error');
    $arr = json_decode($inputData, true);
    $login = $arr['login'];
    $pass = $arr['pass'];
}

/**
 * @param $login - user name
 * @return string password for user $login
 */
function getPassFor($login)
{
    require_once 'DataBase.php';
    $db = DataBase::connectDB();
    $query = mysqli_query($db, "SELECT user, password FROM users WHERE user='$login'");
    $data = mysqli_fetch_assoc($query);
    DataBase::closeDB($db);
    return $data['password'];
}
