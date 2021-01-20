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
                return $this->redirect(['msg' => 'Pre túto akciu nie ste autorizovaný/á'], "Home");
            }
        } else {
            return $this->redirect(['msg' => 'Pre túto akciu sa prihláste'], "Home");
        }
    }

    public function users() {
        $user = $this->app->getAuthController()->getUser();
        if($user != null) {
            if($user->getUserType() == 2) {
                return $this->html(User::getAll());
            } else {
                return $this->redirect(['msg' => 'Pre túto akciu nie ste autorizovaný/á'], "Home");
            }
        } else {
            return $this->redirect(['msg' => 'Pre túto akciu sa prihláste'], "Home");
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
                return $this->redirect(['msg' => 'Pre túto akciu nie ste autorizovaný/á'], "Home");
            }

        } else {
            return $this->redirect(['msg' => 'Pre túto akciu sa prihláste'], "Home");
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
                return $this->redirect(['msg' => 'Pre túto akciu nie ste autorizovaný/á'], "Home");
            }
        } else {
            return $this->redirect(['msg' => 'Pre túto akciu sa prihláste'], "Home");
        }
    }

    public function delete()
    {
        $user = $this->app->getAuthController()->getUser();
        if ($user != null) {
            if ($user->getUserType() == 2) {
                $form_data = $this->app->getRequest()->getPost();
                $favfilms = FavFilm::getAll("id_film =?", [$form_data['id_film']]);
                foreach ($favfilms as $fav) {
                    $fav->delete("id_user");
                }
                $film = Film::getOne($form_data['id_film']);
                $film->delete();
            } else {
                return $this->redirect(['msg' => 'Pre túto akciu nie ste autorizovaný/á'], "Home");
            }
        } else {
            return $this->redirect(['msg' => 'Pre túto akciu sa prihláste'], "Home");
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
                return $this->redirect(['msg' => 'Pre túto akciu nie ste autorizovaný/á'], "Home");
            }
        } else {
            return $this->redirect(['msg' => 'Pre túto akciu sa prihláste'], "Home");
        }
    }

    public function deleteUser() {
        $user = $this->app->getAuthController()->getUser();
        if ($user != null) {
            if ($user->getUserType() == 2) {
                $form_data = $this->app->getRequest()->getPost();
                $favfilms = FavFilm::getAll("id_user =?", [$form_data['id_user']]);
                foreach ($favfilms as $fav) {
                    $fav->delete("id_user");
                }
                $user = User::getOne($form_data['id_user']);
                $user->delete();
            } else {
                return $this->redirect(['msg' => 'Pre túto akciu nie ste autorizovaný/á'], "Home");
            }
        } else {
            return $this->redirect(['msg' => 'Pre túto akciu sa prihláste'], "Home");
        }
    }
}