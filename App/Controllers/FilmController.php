<?php


namespace App\Controllers;

use App\Core\AControllerBase;
use App\Models\Film;

class FilmController extends AControllerBase
{

    public function index()
    {
        return $this->html();
    }

    public function drama() {
        return $this->json(Film::getAll("film_type = 1"));
    }

    public function action() {
        return $this->json(Film::getAll("film_type = 2"));
    }

    public function romantic() {
        return $this->json(Film::getAll("film_type = 3"));
    }
}