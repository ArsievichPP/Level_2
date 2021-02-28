<?php
Header("Access-Control-Allow-Origin: http://host2.com");
Header("Access-Control-Allow-Credentials: true");
Header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
Header("Access-Control-Allow-Headers: X-Requested-With, Content-Type");

$router = new Router();
$router->run();

class Router
{
    const POSSIBLE_ACTIONS = array( // list of available actions
        'logout',
        'addItem',
        'changeItem',
        'deleteItem',
        'getItems',
        'register',
        'login'
    );

    /**
     * checks if an action is valid and performs it or returns an error
     */
    public function run()
    {
        $action = $_GET['action'];

        if ($this->isPossibleAction($action)) {
            require_once "$action.php";
        } else {
            header('HTTP/1.1 404 Not Found');
        }
    }

    /**
     * @param $action - input action
     * @return bool - true if this is a valid action, otherwise false
     */
    public function isPossibleAction($action)
    {
        return in_array($action, self::POSSIBLE_ACTIONS);
    }
}



