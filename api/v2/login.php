<?php
Header("Access-Control-Allow-Origin: http://host2.com");
Header("Access-Control-Allow-Credentials: true");
Header("Access-Control-Allow-Methods: POST");
Header("Access-Control-Allow-Headers: Content-Type");

session_start();
$inputLogin = "";
$inputPass = "";
getInputData($inputLogin, $inputPass);

$user_inf = getInfAboutUser($inputLogin);

if (isset($user_inf['pass'], $user_inf['user_id']) && md5($inputPass) === $user_inf['pass']) {
    $_SESSION['user_id'] = $user_inf['user_id'];
    echo json_encode(array('ok' => true));
} else {
    Header('HTTP/1.1 404 Not Found');
}

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
 * @param $login - username
 * @return array - [user_id => $id, pass => $password]
 */
function getInfAboutUser($login)
{
    require_once 'DataBase.php';
    $db = DataBase::connectDB();
    $query = $db->prepare("SELECT id, password FROM users WHERE login=?");

    $user_inf = array();
    if ($query->execute([$login])) {
        $answer = $query->fetch();
        $user_inf['user_id'] = $answer[0];
        $user_inf['pass'] = $answer[1];
    }
    return $user_inf;
}

