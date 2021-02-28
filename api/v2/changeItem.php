<?php
Header ("Access-Control-Allow-Origin: http://host2.com");
Header ("Access-Control-Allow-Credentials: true");
Header ("Access-Control-Allow-Methods: PUT");
Header ("Access-Control-Allow-Headers: Content-Type");

session_start();
$input = getInputData();
$user_id = $_SESSION['user_id'];
$bool = findAndUpdateRow($user_id, $input['id'], $input['text'], (int)$input['checked']);

if ($bool){
    echo json_encode(array("ok" => true));
}else{
    echo json_encode(array("ok" => false));
}

/**
 * @return mixed input data
 */
function getInputData()
{
    $inputData = file_get_contents('php://input')
    or die('error');
    return json_decode($inputData, true);
}

/**
 * finds an item by input data (id, user id) and updates its 'text'-field or 'checked'-field
 * @param $user_id
 * @param $id
 * @param $text
 * @param $checked
 * @return bool - true if the request was completed, otherwise - false
 */
function findAndUpdateRow($user_id, $id, $text, $checked)
{
    require_once 'DataBase.php';
    $db = DataBase::connectDB();
    $query = "UPDATE items SET text = :text, checked = :checked WHERE items.id = :id AND items.user_id = :user_id";
    $param = array('id' => $id,
        'text' => $text,
        'checked' => $checked,
        'user_id' => $user_id);

    $sql = $db->prepare($query);
    return $sql->execute($param);
}
