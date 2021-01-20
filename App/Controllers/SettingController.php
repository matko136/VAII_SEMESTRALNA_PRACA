<?php


namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\Responses\Response;


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
}