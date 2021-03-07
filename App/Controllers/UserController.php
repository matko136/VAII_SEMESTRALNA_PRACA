<?php


namespace App\Controllers;

use App\Core\AControllerBase;
use App\Models\User;

class UserController extends AControllerBase
{

    public function index()
    {
        $user = $this->app->getAuthController()->getUser();
        if($user != null) {
            if($user->getUserType() == 2 || $user->getUserType() == 3) {
                return $this->json(User::getAll());
            } else {
                $notlogged = array('Not authorized');
                return $this->json($notlogged);
            }
        } else {
            $notlogged = array('Not logged');
            return $this->json($notlogged);
        }
    }

    public function current_user() {
        $user = $this->app->getAuthController()->getUser();
        if($user->getUserType() == 2 || $user->getUserType() == 3) {
            return $this->json($user);
        } else {
            $notlogged = array('Not authorized');
            return $this->json($notlogged);
        }
    }

    public function add() {
    }
}