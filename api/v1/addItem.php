<?php
Header("Access-Control-Allow-Origin: http://host1.com");
Header("Access-Control-Allow-Credentials: true");
Header("Access-Control-Allow-Methods: POST");
Header("Access-Control-Allow-Headers: Content-Type");


session_start();
$item = getItem();
$tableName = $_SESSION['login'];
$id = addInDB($tableName, $item);
echo json_encode(array('id' => $id));

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
 * add text in $tableName and return its id number
 * @param $tableName - name of table for adding item
 * @param $item - text for add in database
 * @return string - id of this item
 */
function addInDB($tableName, $item)
{
    require_once('DataBase.php');
    $db = DataBase::connectDB();

    $query_addItem = "INSERT INTO $tableName(`text`) VALUES('$item')";
    mysqli_query($db, $query_addItem);

    $id = mysqli_insert_id($db);

    DataBase::closeDB($db);

    return $id;
}



