<?php
Header('Access-Control-Allow-Origin: http://host2.com');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Credentials: true');

session_start();

if (isset($_SESSION['user_id'])) { // If authorized, return the database for this user
    $table = arrayFromDB( $_SESSION['user_id']);
    echo json_encode(array('items' => $table));
} else { // return an empty array
    echo json_encode(array('items' => array()));
}

/**
 * create an array of items from DB for user(user_id)
 * @param $id - user_id
 * @return array with items of this user or empty array.
 */
function arrayFromDB($id): array
{
    require_once "DataBase.php";
    $db = DataBase::connectDB();
    $query = "SELECT id, text, checked FROM items WHERE user_id='$id'";
    $array = array();

    if ($result = $db->query($query)) {
        while ($row = $result->fetch())
            $array[] = array(
                'id' => $row[0],
                'text' => $row[1],
                'checked' => (bool)$row[2],
            );
    }
    return $array;
}
