<?php


namespace App\Controllers;
use App\Core\AControllerBase;
use App\Core\Responses\Response;
use App\Models\User;

class AuthController extends AControllerBase
{
    private $user;
    protected static $instance;

    public static function getInstance(): AuthController {
        if(AuthController::$instance == null) {
            AuthController::$instance = new static();
        }
        return AuthController::$instance;
    }

    public function __construct() {

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
            if(!isset($_SESSION['user'])) {
                $_SESSION['user'] = "";
            } else if($_SESSION['user'] != ""){
                /** @var \App\Models\User $data */
                $data = User::getOne($_SESSION['user']);
                $this->user = $data;
            }
        }
    }

    public function index()
    {
        // TODO: Implement index() method.
    }

    public function login() {
        $form_data = $this->app->getRequest()->getPost();
        if(isset($form_data['submit'])) {
            /** @var \App\Models\User[] $data */
            $data = User::getAll("log = " . "'" .$form_data['log'] . "'");
            if(count($data) == 1) {
                $user = $data[0];
                if(password_verify($form_data['passwd'], $user->getPasswd())) {
                    $_SESSION['user'] = $user->getIdUser();
                    $this->user = $user;
                }
            }
        }
        return $this->redirect(NULL, "Home");
    }

    public function reg() {
        $form_data = $this->app->getRequest()->getPost();
        if(isset($form_data['submit'])) {
            $data = User::getAll("log = " . "'" . $form_data['log'] . "'");
            if(count($data) == 0) {
                $user = new User($form_data['log'], $form_data['name'], $form_data['surename'], $form_data['email'], password_hash($form_data['passwd'], PASSWORD_DEFAULT), 1);
                $user->save();
            }
        }
        return $this->redirect(NULL, "Home");
    }

    public function logOut() {
        $_SESSION['user'] = "";
        $this->user = NULL;
        return $this->redirect(NULL, "Home");
    }

    public function isLog() {
        if(!isset($_SESSION['user'])) {
            return false;
        } else {
            if($_SESSION['user'] != "")
                return true;
            else
                return false;
        }
    }

    public function getUser() : ?User {
        return $this->user;
    }

}