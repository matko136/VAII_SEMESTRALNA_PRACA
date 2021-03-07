<?php


namespace App\Controllers;

use App\Models\Score;
use App\Core\AControllerBase;

class GameController extends AControllerBase
{

    public function index()
    {
        return $this->html();
    }

    public function getScore() {
        return $this->json(Score::getAll());
    }

    public function addScore() {
        $form_data = $this->app->getRequest()->getPost();
        if(isset($form_data['nickname']) && isset($form_data['score'])) {
            $score = new Score($form_data['nickname'], $form_data['score']);
            $score->save();
        }
        return $this->nothing();
    }
}