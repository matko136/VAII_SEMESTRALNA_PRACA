<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\Responses\Response;

class HomeController extends AControllerBase
{

    public function index()
    {
        return $this->html();
    }
}