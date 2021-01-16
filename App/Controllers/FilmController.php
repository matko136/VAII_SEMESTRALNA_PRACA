<?php


namespace App\Controllers;

use App\Core\AControllerBase;
use App\Models\Film;

class FilmController extends AControllerBase
{

    public function index()
    {
        return $this->html(Film::getAll());
    }

    public function drama() {
        return $this->html(Film::getAll("film_type = 1"));
    }

    public function action() {
        return $this->html(Film::getAll("film_type = 2"));
    }

    public function romantic() {
        return $this->html(Film::getAll("film_type = 3"));
    }
}