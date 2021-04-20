<?php
require_once('Controller.php');

class ApplicationController
{
    private static $instance;
    private $routes;

    private function __construct()
    {
        $this->routes = [
            '/' => ['controller' => null, 'view' => 'MainView'],
            'register' => ['controller' => null, 'view' => 'RegisterView'],
            'validLogin' => ['controller' => 'LoginController', 'view' => null],
            'validRegister' => ['controller' => 'RegisterController', 'view' => null],
            'home' => ['controller' => null, 'view' => 'HomeView'],
            'logout' => ['controller' => 'LogoutController', 'view' => null],
            'profile' => ['controller' => null, 'view' => 'ProfileView'],
            'validProfile' => ['controller' => 'ProfileController', 'view' => null],
            'manageBooks' => ['controller' => null, 'view' => "ManageBooksView"],
            'delete' => ['controller' => null, 'view' => 'DeleteView'],
            'validDelete' => ['controller' => 'DeleteController', 'view' => null],
            'addHouses' => ['controller' => null, 'view' => "AddHousesView"],
            'validNewHouse' => ['controller' => 'AddHouseController', 'view' => null],
            'deleteHouse' => ['controller' => 'DeleteHouseController', 'view' => null],
            'addBooks' => ['controller' => null, 'view' => 'AddBooksView'],
            'validAddBook' => ['controller' => 'AddNewBookController', 'view' => null],
            'deleteBook' => ['controller' => 'DeleteBookController', 'view' => null],
            'manageBook' => ['controller' => null, 'view' => 'ManageOneBookView'],
            'modifyBook' => ['controller' => 'ModifyBookController', 'view' => null],
            'manageHouses' => ['controller' => null, 'view' => 'ManageHousesView'],
            'searchBook' => ['controller' => null, 'view' => 'SearchBookView'],
            'manageAdmin' => ['controller' => null, 'view' => 'ManageAdminView'],
            'addImage' => ['controller' => null, 'view' => 'AddImageView'],
            'uploadFile' => ['controller' => 'UploadFileController', 'view' => null]
        ];
    }

    /**
     * Returns the single instance of this class.
     * @return ApplicationController the single instance of this class.
     */
    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new ApplicationController;
        }
        return self::$instance;
    }

    /**
     * Returns the controller that is responsible for processing the request
     * specified as parameter. The controller can be null if their is no data to
     * process.
     * @param Array $request The HTTP request.
     * @param Controller The controller that is responsible for processing the
     * request specified as parameter.
     * @return The controller associate if exists
     */
    public function getController($request)
    {
        if (array_key_exists($request['page'], $this->routes)) {
            return $this->routes[$request['page']]['controller'];
        }
        return null;
    }

    /**
     * Returns the view that must be return in response of the HTTP request
     * specified as parameter.
     * @param Array $request The HTTP request.
     * @param Object The view that must be return in response of the HTTP request
     * @return The view associate if exists
     * specified as parameter.
     */
    public function getView($request)
    {
        if (array_key_exists($request['page'], $this->routes)) {
            return $this->routes[$request['page']]['view'];
        }
        header('Location:?page=/');
    }
}