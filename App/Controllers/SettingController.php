<?php


namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\Responses\Response;
use App\Models\FavFilm;
use App\Models\User;


class SettingController extends AControllerBase
{

    public function index()
    {
        $user = $this->app->getAuthController()->getUser();
        if ($user != null) {
            return $this->html();
        }
        return $this->redirect(['msg' => 'Pre túto akciu sa prihláste'], "Home");
    }

    public function delete()
    {
        $user = $this->app->getAuthController()->getUser();
        if ($user != null) {
            $favfilms = FavFilm::getAll("id_user =?", [$user->getIdUser()]);
            foreach ($favfilms as $fav) {
                $fav->delete("id_user");
            }
            $user->delete();
        }
        if (session_status() == PHP_SESSION_ACTIVE)
            session_destroy();
        return $this->redirect(['msg' => 'Konto bolo zmazané'], "Home");
    }
}