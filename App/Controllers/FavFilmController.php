<?php


namespace App\Controllers;

use App\Core\AControllerBase;
use App\Models\FavFilm;
use App\Models\Film;

class FavFilmController extends AControllerBase
{

    public function index() {
        return $this->html();
    }

    public function drama() {
        return $this->html();
    }

    public function action() {
        return $this->html();
    }

    public function romantic() {
        return $this->html();
    }

    public function index_get()
    {
        if($_SESSION['user'] == "") {
            $notlogged = array('NotLogged');
            return $this->json($notlogged);
        }
        $dataa = FavFilm::getAll("id_user =?", [$_SESSION['user']]);
        $dataa[count($dataa)] = $_SESSION['user'];
        return $this->json($dataa);
    }

    public function drama_get() {
        if($_SESSION['user'] == "") {
            $notlogged = array('NotLogged');
            return $this->json($notlogged);
        }
        $dataa = FavFilm::getAll("id_user =? and EXISTS(SELECT id_film from film where favorite_film.id_film = film.id_film and film_type=1)", [$_SESSION['user']]);
        $dataa[count($dataa)] = $_SESSION['user'];
        return $this->json($dataa);
    }

    public function action_get() {
        if($_SESSION['user'] == "") {
            $notlogged = array('NotLogged');
            return $this->json($notlogged);
        }
        $dataa = FavFilm::getAll("id_user =? and EXISTS(SELECT id_film from film where favorite_film.id_film = film.id_film and film_type=2)", [$_SESSION['user']]);
        $dataa[count($dataa)] = $_SESSION['user'];
        return $this->json($dataa);
    }

    public function romantic_get() {
        if($_SESSION['user'] == "") {
            $notlogged = array('NotLogged');
            return $this->json($notlogged);
        }
        $dataa = FavFilm::getAll("id_user =? and EXISTS(SELECT id_film from film where favorite_film.id_film = film.id_film and film_type=3)", [$_SESSION['user']]);
        $dataa[count($dataa)] = $_SESSION['user'];
        return $this->json($dataa);
    }

    public function add() {
        $form_data = $this->app->getRequest()->getPost();
        if($_SESSION['user'] == "" || $_SESSION['user'] != $form_data['id_user']) {
            $notlogged = array('NotLogged');
            return $this->json($notlogged);
        }
        $form_data = $this->app->getRequest()->getPost();
        if(isset($form_data['id_user']) && isset($form_data['id_film'])) {
            $fav = new FavFilm($form_data['id_user'], $form_data['id_film']);
            $pks = array('id_user', 'id_film');
            $fav->save(true);
        }
        return $this->nothing();
    }

    public function remove() {
        $form_data = $this->app->getRequest()->getPost();
        if($_SESSION['user'] == "" || $_SESSION['user'] != $form_data['id_user']) {
            $notlogged = array('NotLogged');
            return $this->json($notlogged);
        }
        if(isset($form_data['id_user']) && isset($form_data['id_film'])) {
            $fav = FavFilm::getOne($form_data['id_film'], "id_user", $form_data['id_user']);
            $fav->delete("id_user");
        }
        return $this->nothing();
    }
}