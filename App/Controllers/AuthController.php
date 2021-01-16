<?php


namespace App\Controllers;
use App\Core\AControllerBase;
use App\Core\Responses\Response;
use App\Models\User;

class AuthController extends AControllerBase
{
    private $user;

    public function __construct() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
            if(!isset($_SESSION['user'])) {
                $_SESSION['user'] = 1;
            } else {
                $_SESSION['user'] = 1;
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
            User::getAll("log = " . $form_data['log']);
            /** @var \App\Models\User[] $data */
            if(count($data) == 1) {
                $user = $data[0];
                if(password_verify($form_data[paswd], $user->getPsswd())) {
                    $_SESSION['user'] = $user->getIdUser();
                    $this->user = $user;
                }
            }
        }
    }

    public function reg() {
        $form_data = $this->app->getRequest()->getPost();
        if(isset($form_data['submit'])) {
            User::getAll("log = " . $form_data['log']);
            /** @var \App\Models\User[] $data */
            if(count($data) == 0) {
                $user = new User($form_data['log'], $form_data['name'], $form_data['surename'], $form_data['email'], password_hash($form_data['passwd'], PASSWORD_DEFAULT), 1);
                $user->save();
            }
        }
    }

    public function isLog() {
        if(!isset($_SESSION['user'])) {
            return false;
        } else {
            return true;
        }
    }

    public function getUser() : User {
        return $this->user;
    }

}