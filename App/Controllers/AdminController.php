<?php


namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\Responses\Response;
use App\Models\FavFilm;
use App\Models\Film;
use App\Models\User;
class AdminController extends AControllerBase
{

    public function index()
    {
        $user = $this->app->getAuthController()->getUser();
        if ($user != null) {
            if ($user->getUserType() == 2) {
                return $this->html(Film::getAll());
            } else {
                $notlogged = array('Not authorized');
                return $this->json($notlogged);
            }
        } else {
            $notlogged = array('Not logged');
            return $this->json($notlogged);
        }
    }

    public function users() {
        $user = $this->app->getAuthController()->getUser();
        if($user != null) {
            if($user->getUserType() == 2) {
                return $this->html(User::getAll());
            } else {
                $notlogged = array('Not authorized');
                return $this->json($notlogged);
            }
        } else {
            $notlogged = array('Not logged');
            return $this->json($notlogged);
        }
    }

    public function edit()
    {
        $user = $this->app->getAuthController()->getUser();
        if ($user != null) {
            if ($user->getUserType() == 2) {
                $form_data = $this->app->getRequest()->getPost();
                $film = Film::getOne($form_data['id_film']);
                $film->setImg($form_data['img']);
                $film->setTitle($form_data['title']);
                $film->setAboutFilm($form_data['about_film']);
                $film->setFilmType($form_data['film_type']);
                $film->save();
            } else {
                $notlogged = array('Not authorized');
                return $this->json($notlogged);
            }

        } else {
            $notlogged = array('Not logged');
            return $this->json($notlogged);
        }
    }

    public function add()
    {
        $user = $this->app->getAuthController()->getUser();
        if ($user != null) {
            if ($user->getUserType() == 2) {
                $form_data = $this->app->getRequest()->getPost();
                $film = new Film($form_data['img'], $form_data['title'], $form_data['about_film'], $form_data['film_type']);
                $film->save();
            } else {
                $notlogged = array('Not authorized');
                return $this->json($notlogged);
            }
        } else {
            $notlogged = array('Not logged');
            return $this->json($notlogged);
        }
    }

    public function delete()
    {
        $user = $this->app->getAuthController()->getUser();
        if ($user != null) {
            if ($user->getUserType() == 2) {
                $form_data = $this->app->getRequest()->getPost();
                $favfilms = FavFilm::getAll("id_film =" . $form_data['id_film']);
                foreach ($favfilms as $fav) {
                    $fav->delete("id_film=" . $form_data['id_film']);
                    break;
                }
                $film = Film::getOne($form_data['id_film']);
                $film->delete();
            } else {
                $notlogged = array('Not authorized');
                return $this->json($notlogged);
            }
        } else {
            $notlogged = array('Not logged');
            return $this->json($notlogged);
        }
    }

    public function editUserType() {
        $user = $this->app->getAuthController()->getUser();
        if ($user != null) {
            if ($user->getUserType() == 2) {
                $form_data = $this->app->getRequest()->getPost();
                $user = User::getOne($form_data['id_user']);
                $user->setUserType($form_data['user_type']);
                $user->save();
            } else {
                $notlogged = array('Not authorized');
                return $this->json($notlogged);
            }
        } else {
            $notlogged = array('Not logged');
            return $this->json($notlogged);
        }
    }

    public function deleteUser() {
        $user = $this->app->getAuthController()->getUser();
        if ($user != null) {
            if ($user->getUserType() == 2) {
                $form_data = $this->app->getRequest()->getPost();
                $favfilms = FavFilm::getAll("id_user =" . $form_data['id_user']);
                foreach ($favfilms as $fav) {
                    $fav->delete("id_user=" . $form_data['id_user']);
                    break;
                }
                $user = User::getOne($form_data['id_user']);
                $user->delete();
            } else {
                $notlogged = array('Not authorized');
                return $this->json($notlogged);
            }
        } else {
            $notlogged = array('Not logged');
            return $this->json($notlogged);
        }
    }
}