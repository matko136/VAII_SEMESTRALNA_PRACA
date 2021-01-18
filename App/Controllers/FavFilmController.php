<?php


namespace App\Controllers;

use App\Core\AControllerBase;
use App\Models\FavFilm;
use App\Models\Film;

class FavFilmController extends AControllerBase
{

    public function index()
    {
        if($_SESSION['user'] == "") {
            $notlogged = array('NotLogged');
            return $this->json($notlogged);
        }
        return $this->json(FavFilm::getAll("id_user =" . $_SESSION['user']));
    }

    public function drama() {
        if($_SESSION['user'] == "") {
            $notlogged = array('NotLogged');
            return $this->json($notlogged);
        }
        $dataa = FavFilm::getAll("id_user =" . $_SESSION['user']);
        $dataa[count($dataa)] = $_SESSION['user'];
        return $this->json($dataa);
    }

    public function action() {
        if($_SESSION['user'] == "") {
            $notlogged = array('NotLogged');
            return $this->json($notlogged);
        }
        return $this->json(FavFilm::getAll("id_user =" . $_SESSION['user']));
    }

    public function romantic() {
        if($_SESSION['user'] == "") {
            $notlogged = array('NotLogged');
            return $this->json($notlogged);
        }
        return $this->json(FavFilm::getAll("id_user =" . $_SESSION['user']));
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
        if(isset($form_data['id_user']) && isset($form_data['id_film'])) {
            $fav = FavFilm::getOne("0", " id_user =" . $form_data['id_user'] . " and id_film =" . $form_data['id_film'] );
            $fav->delete(" id_user =" . $form_data['id_user'] . " and id_film =" . $form_data['id_film']);
        }
        return $this->nothing();
    }
}