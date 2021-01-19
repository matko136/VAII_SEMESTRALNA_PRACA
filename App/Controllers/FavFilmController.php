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
        $dataa = FavFilm::getAll("id_user =" . $_SESSION['user']);
        $dataa[count($dataa)] = $_SESSION['user'];
        return $this->json($dataa);
    }

    public function drama_get() {
        if($_SESSION['user'] == "") {
            $notlogged = array('NotLogged');
            return $this->json($notlogged);
        }
        $dataa = FavFilm::getAll("id_user =" . $_SESSION['user'] . " and EXISTS(SELECT id_film from film where favorite_film.id_film = film.id_film and film_type=1)");
        $dataa[count($dataa)] = $_SESSION['user'];
        return $this->json($dataa);
    }

    public function action_get() {
        if($_SESSION['user'] == "") {
            $notlogged = array('NotLogged');
            return $this->json($notlogged);
        }
        $dataa = FavFilm::getAll("id_user =" . $_SESSION['user'] . " and EXISTS(SELECT id_film from film where favorite_film.id_film = film.id_film and film_type=2)");
        $dataa[count($dataa)] = $_SESSION['user'];
        return $this->json($dataa);
    }

    public function romantic_get() {
        if($_SESSION['user'] == "") {
            $notlogged = array('NotLogged');
            return $this->json($notlogged);
        }
        $dataa = FavFilm::getAll("id_user =" . $_SESSION['user'] . " and EXISTS(SELECT id_film from film where favorite_film.id_film = film.id_film and film_type=3)");
        $dataa[count($dataa)] = $_SESSION['user'];
        return $this->json($dataa);
    }

    public function add() {
        if($_SESSION['user'] == "") {
            $notlogged = array('NotLogged');
            return $this->json($notlogged);
        }
        $form_data = $this->app->getRequest()->getPost();
        if(isset($form_data['id_user']) && isset($form_data['id_film'])) {
            $fav = new FavFilm($form_data['id_user'], $form_data['id_film']);
            $pks = array('id_user', 'id_film');
            $fav->save($pks);
        }
        return $this->nothing();
    }

    public function remove() {
        if($_SESSION['user'] == "") {
            $notlogged = array('NotLogged');
            return $this->json($notlogged);
        }
        $form_data = $this->app->getRequest()->getPost();
        if(isset($form_data['id_user']) && isset($form_data['id_film'])) {
            $fav = FavFilm::getOne("0", " id_user =" . $form_data['id_user'] . " and id_film =" . $form_data['id_film'] );
            $fav->delete(" id_user =" . $form_data['id_user'] . " and id_film =" . $form_data['id_film']);
        }
        return $this->nothing();
    }
}