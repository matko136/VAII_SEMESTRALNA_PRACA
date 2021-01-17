<?php


namespace App\Controllers;

use App\Core\AControllerBase;
use App\Models\FavFilm;
use App\Models\Film;

class FavFilmController extends AControllerBase
{

    public function index()
    {
        return $this->html(FavFilm::getAll("film_type = 1 and id_user =" . $_SESSION['user']));
    }

    public function drama() {
        return $this->json(FavFilm::getAll("film_type = 1 and id_user =" . $_SESSION['user']));
    }

    public function action() {
        return $this->json(FavFilm::getAll("film_type = 2 and id_user =" . $_SESSION['user']));
    }

    public function romantic() {
        return $this->json(FavFilm::getAll("film_type = 3 and id_user =" . $_SESSION['user']));
    }

    public function add() {
        $form_data = $this->app->getRequest()->getPost();
        if(isset($form_data['id_user']) && isset($form_data['id_film'])) {
            $fav = new FavFilm($form_data['id_user'], $form_data['id_film']);
            $pks = array('id_user', 'id_film');
            $fav->save($pks);
        }
        return $this->redirect(Film::getAll("film_type = 1"), "Film");
    }

    public function remove() {
        $form_data = $this->app->getRequest()->getPost();
        if(isset($form_data['user']) && isset($form_data['film'])) {
            $fav = FavFilm::getOne(0, " id_user =" . $form_data['user'] . " and id_film =" . $form_data['film'] );
            $fav->delete(" id_user =" . $form_data['user'] . " and id_film =" . $form_data['film']);
        }
    }
}