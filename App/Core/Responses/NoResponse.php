<?php


namespace App\Core\Responses;


class NoResponse extends Response
{

    public function generate()
    {
        return true;
    }
}