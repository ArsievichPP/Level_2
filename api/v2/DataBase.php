<?php
Header("Access-Control-Allow-Origin: http://host2.com");
Header("Access-Control-Allow-Credentials: true");
Header("Access-Control-Allow-Methods: POST");
Header("Access-Control-Allow-Headers: Content-Type");

class DataBase
{
    const host = 'localhost';
    const database = 'to-do-v2';
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
        try {
            return new PDO(
                'mysql:host='.self::host.';dbname='.self::database,
                self::user,
                self::password);
        }catch (PDOException $e){
            echo "Error!:". $e->getMessage();
            exit();
        }
    }

    /**
     * creates a table if doesn't exist in db for storing information
     * about registered users (id, login, password)
     */
    public static function createTableForUsers(){
        $db = self::connectDB();
        $db->query("CREATE TABLE IF NOT EXISTS users(
        id INT NOT NULL UNIQUE AUTO_INCREMENT,
        login VARCHAR(255) NOT NULL,
        password VARCHAR(255) NOT NULL)");
    }

    /**
     * creates a table if doesn't exist to store items (id, text, checked, user_id)
     */
    public static function createTableForItems()
    {
        $db = self::connectDB();
        $db->query("CREATE TABLE IF NOT EXISTS items(
        id INT NOT NULL UNIQUE AUTO_INCREMENT,
        text VARCHAR(255) NOT NULL,
        checked TINYINT(1) DEFAULT(1),
        user_id INT NOT NULL)");
    }


}

