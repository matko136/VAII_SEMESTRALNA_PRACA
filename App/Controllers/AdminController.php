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
            if ($user->getUserType() == 2  || $user->getUserType() == 3) {
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
            if($user->getUserType() == 2 || $user->getUserType() == 3) {
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
            if ($user->getUserType() == 2  || $user->getUserType() == 3) {
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
            if ($user->getUserType() == 2  || $user->getUserType() == 3) {
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
            if ($user->getUserType() == 2 || $user->getUserType() == 3) {
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
            if ($user->getUserType() == 2 || $user->getUserType() == 3) {
                $input = json_decode(file_get_contents('php://input'), true);
                $userr = User::getOne($input['id_user']);
                if($userr->getUserType() == 2 && $user->getUserType() != 3) {
                    return $this->json(array('msg' => 'Nie je možné meniť údaje iného administrátora', 'success' => 'no'));
                }
                if($input['user_type'] != '1' && $input['user_type'] != '2')
                    return $this->json(array('msg' => 'Zle zadanný typ užívateľa', 'success' => 'no'));
                $userr->setUserType($input['user_type']);
                $userr->save();
                return $this->json(array('msg' => 'Úspešná zmena údajov', 'success' => 'yes'));
            } else {
                return $this->json(array('msg' => 'Pre túto akciu nie ste autorizovaný/á', 'success' => 'no'));
            }
        } else {
            return $this->json(array('msg' => 'Pre túto akciu sa prihláste', 'success' => 'no'));
        }
    }

    public function deleteUser() {
        $user = $this->app->getAuthController()->getUser();
        if ($user != null) {
            if ($user->getUserType() == 2 || $user->getUserType() == 3) {
                $input = json_decode(file_get_contents('php://input'), true);
                $userr = User::getOne($input['id_user']);
                if(($userr->getUserType() == 2 || $userr->getUserType() == 3) && $user->getUserType() != 3) {
                    return $this->json(array('msg' => 'Nie je možné vymazať iného administrátora', 'success' => 'no'));
                }
                $favfilms = FavFilm::getAll("id_user =?", [$input['id_user']]);
                foreach ($favfilms as $fav) {
                    $fav->delete("id_user");
                }
                $userr->delete();
                return $this->json(array('msg' => 'Úspešné vymazanie používateľa', 'success' => 'yes'));
            } else {
                return $this->json(array('msg' => 'Pre túto akciu nie ste autorizovaný/á', 'success' => 'no'));
            }
        } else {
            return $this->json(array('msg' => 'Pre túto akciu sa prihláste', 'success' => 'no'));
        }
    }
}