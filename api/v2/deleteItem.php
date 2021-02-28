<?php
Header ("Access-Control-Allow-Origin: http://host2.com");
Header ("Access-Control-Allow-Credentials: true");
Header ("Access-Control-Allow-Methods: DELETE");
Header ("Access-Control-Allow-Headers: Content-Type");

session_start();
$inputArr = getInputData();
$bool = findAndDeleteRow($inputArr['id']);
echo json_encode(array("ok" => $bool));

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
 * deletes the entry with the specified id
 * @param $id - number of item
 * @return bool true if the request was completed, otherwise - false
 */
function findAndDeleteRow($id)
{
    require_once 'DataBase.php';
    $query = "DELETE FROM items WHERE items.id = :id AND user_id = :user_id";
    $param = array('id' => $id,
        'user_id' => $_SESSION['user_id']);
    $db = DataBase::connectDB();
    $sql = $db->prepare($query);
    $sql->execute($param);
    return $sql->execute($param);
}
