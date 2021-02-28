<?php
Header("Access-Control-Allow-Origin: http://host2.com");
Header("Access-Control-Allow-Credentials: true");
Header("Access-Control-Allow-Methods: POST");
Header("Access-Control-Allow-Headers: Content-Type");

session_start();
if (isset($_SESSION['user_id'])) { // if session active, add text in db
    $item = getItem();
    $id = addInDB($item);
    echo json_encode(array('id' => $id));
}else{
    header('HTTP/1.1 400 Bad Request');
    exit();
}

/**
 * @return mixed input data;
 */
function getItem()
{
    $inputData = file_get_contents('php://input')
    or die('error');
    return json_decode($inputData, true)['text'];
}

/**
 * add text in db and return its id number
 * @param $item - text for add in database
 * @return string - id of this item
 */
function addInDB($item)
{
    require_once('DataBase.php');
    $db = DataBase::connectDB();
    $user_id = $_SESSION['user_id'];
    $query = "INSERT INTO items(text, user_id) VALUES(?, ?)";
    $sql = $db->prepare($query);
    $sql->execute(array($item, $user_id));
    return $db->lastInsertId();
}



