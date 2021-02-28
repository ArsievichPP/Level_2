<?php
Header ("Access-Control-Allow-Origin: http://host1.com");
Header ("Access-Control-Allow-Credentials: true");
Header ("Access-Control-Allow-Methods: PUT");
Header ("Access-Control-Allow-Headers: Content-Type");

session_start();
$input = getInputData();
$tableName = $_SESSION['login'];
$bool = findAndUpdateRow($tableName, $input['id'], $input['text'], (int)$input['checked']);

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
 * finds an item by input data (id) in $tableName and updates its 'text'-field or 'checked'-field
 * @param $tableName
 * @param $id
 * @param $text
 * @param $checked
 * @return bool|mysqli_result
 */
function findAndUpdateRow($tableName, $id, $text, $checked)
{
    require_once 'DataBase.php';
    $query = "UPDATE $tableName SET text = '$text', checked = '$checked' WHERE $tableName.id = '$id'";
    return DataBase::executeRequest($query);
}
