<?php


namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\Responses\Response;
use App\Models\FavFilm;
use App\Models\Film;

class AdminController extends AControllerBase
{

    public function index()
    {
        return $this->html(Film::getAll());
    }

    public function edit()
    {
        // TODO: Implement index() method.
    }

    public function add()
    {
    }

    public function delete()
    {
        $form_data = $this->app->getRequest()->getPost();
        $favfilms = FavFilm::getAll("id_film =" . $form_data['id_film']);
        foreach ($favfilms as $fav) {
            $fav->delete("id_film=" . $form_data['id_film']);
            break;
        }
        $film = Film::getOne($form_data['id_film']);
        $film->delete();
    }
}