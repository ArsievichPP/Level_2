<?php
Header('Access-Control-Allow-Origin: http://host1.com');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Credentials: true');

session_start();

if (isset($_SESSION['login'])) { // If authorized, return the database for this user
    $table = arrayFromDB( $_SESSION['login']);
    echo json_encode(array('items' => $table));
} else { // return an empty array
    echo json_encode(array('items' => array()));
}

/**
 * create an array of items from DB for user
 * @param $tableName - name of table for creating array
 * @return array with items of this user or empty array.
 */function arrayFromDB($tableName): array
{
    require_once "DataBase.php";
    $db = DataBase::connectDB();
    $query = "SELECT * FROM $tableName";
    $array = array();

    if ($table = mysqli_query($db, $query)) {
        while ($row = mysqli_fetch_row($table))
            $array[] = array(
                'id' => $row[0],
                'text' => $row[1],
                'checked' => (bool)$row[2],
            );
    }
    mysqli_close($db);
    return $array;
}
