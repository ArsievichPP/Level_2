<?php
Header("Access-Control-Allow-Origin: http://host1.com");
Header("Access-Control-Allow-Credentials: true");
Header("Access-Control-Allow-Methods: POST");
Header("Access-Control-Allow-Headers: Content-Type");

class DataBase
{
    const host = 'localhost';
    const database = 'to-do';
    const user = 'root';
    const password = '';

    /**
     * Connects to a database and returns a pdo object
     * @return PDO object of database
     *
     * if there is a problem with connecting to the database,
     * the function will terminate and give an error.
     */
    public static function connectDB()
    {
        $db = mysqli_connect(
            self::host,
            self::user,
            self::password,
            self::database)
        or die('db connect error');
        return $db;
    }


    public static function executeRequest($request)
    {
        $db = self::connectDB();
        $bool = mysqli_query($db, $request);
        self::closeDB($db);
        return $bool;
    }


    /**
     * closes the database connection
     * @param $dbName - link to open database
     */
    public static function closeDB($dbName)
    {
        mysqli_close($dbName);
    }

    /**
     * creates a table if doesn't exist to store items (id, text, checked)
     */
    public static function createTableForItems(string $tableName)
    {
        if ($tableName === 'users')
            return false;

        $query = "CREATE TABLE IF NOT EXISTS $tableName(
        id INT(11) NOT NULL UNIQUE AUTO_INCREMENT,
        text VARCHAR(255) NOT NULL,
        checked TINYINT(1) DEFAULT(1))";

        return self::executeRequest($query);
    }

    /**
     * creates a table if doesn't exist in db for storing information
     * about registered users (login, password)
     */
    public static function createTableForUsers()
    {
        $query = "CREATE TABLE IF NOT EXISTS users(
        user VARCHAR(255) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL)";

        return self::executeRequest($query);
    }
}

