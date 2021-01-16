<?php


namespace App\Controllers;

use App\Core\AControllerBase;
use App\Models\User;

class UserController extends AControllerBase
{

    public function index()
    {
        return $this->html(User::getAll());
    }

    public function add() {
    }
}