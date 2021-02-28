<?php
Header ("Access-Control-Allow-Origin: http://host1.com");
Header ("Access-Control-Allow-Credentials: true");
Header ("Access-Control-Allow-Methods: DELETE");
Header ("Access-Control-Allow-Headers: Content-Type");

session_start();
$tableName = $_SESSION['login'];
$inputArr = getInputData();
$bool = findAndDeleteRow($tableName, $inputArr['id']);

if ($bool){
    echo json_encode(array("ok" => true));
}else{
    echo json_encode(array("ok" => false));
}

function getInputData()
{
    $inputData = file_get_contents('php://input')
    or die('error');
    return json_decode($inputData, true);
}

/**
 * @param $tableName - name of tables for searching item
 * @param $id - number of item
 * @return bool - true if the request was completed, otherwise - false
 */
function findAndDeleteRow($tableName, $id)
{
    require_once 'DataBase.php';
    $query = "DELETE FROM $tableName WHERE $tableName.id = '$id'";
    return (bool)DataBase::executeRequest($query);
}
