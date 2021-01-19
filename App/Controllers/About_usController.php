<?php


namespace App\Controllers;
use App\Core\AControllerBase;

class About_usController extends AControllerBase
{

    public function index()
    {
        return $this->html();
    }
}