<?php

namespace App\Core;

use App\App;
use App\Core\Responses\JsonResponse;
use App\Core\Responses\RedirectResponse;
use App\Core\Responses\Response;
use App\Core\Responses\ViewResponse;

/**
 * Class AControllerBase
 * Basic controller class, predecessor of all controllers
 * @package App\Core
 */
abstract class AControllerBase
{
    /**
     * Reference to APP object instance
     * @var App
     */
     protected App $app;

    /**
     * Returns controller name (without Controller prefix)
     * @return string
     */
    public function getName()  : string
    {
        return str_replace("Controller", "", $this->getClassName());
    }

    /**
     * Return full class name
     * @return string
     */
    public function getClassName()
    {
        $arr = explode("\\", get_class($this));
        return end($arr);
    }

    /**
     * Method for injecting App object
     * @param App $app
     */
    public function setApp(App $app)
    {
        $this->app = $app;
    }

    /**
     * Helper method for returning response type ViewResponse
     * @param null $data
     * @param null $viewName
     * @return ViewResponse
     */
    protected function html($data = null, $viewName = null) : ViewResponse
    {
        if ($viewName == null) {
            $viewName = $this->app->getRouter()->getControllerName() . DIRECTORY_SEPARATOR . $this->app->getRouter()->getAction();
        } else {
            $viewName = is_string($viewName) ? ($this->app->getRouter()->getControllerName() . DIRECTORY_SEPARATOR . $viewName) : ($viewName['0'] . DIRECTORY_SEPARATOR . $viewName['1']);
        }
        return new ViewResponse($this->app, $viewName, $data);
    }

    protected function redirect($data = null, $viewName = null) : RedirectResponse {
        if ($viewName == null) {
            $viewName = $this->app->getRouter()->getControllerName() . DIRECTORY_SEPARATOR . $this->app->getRouter()->getAction();
        } else {
            $viewName = is_string($viewName) ? ($viewName) : ($viewName['0'] . DIRECTORY_SEPARATOR . $viewName['1']);
        }
        return new RedirectResponse($this->app, $viewName, $data);
    }
    /**
     * Helper method for returning response type JsonResponse
     * @param $data
     * @return JsonResponse
     */
    public function json($data) : JsonResponse
    {
        return new JsonResponse($data);
    }

    /**
     * Helper method for request
     * @return Request
     */
    public function request() : Request
    {
        return $this->app->getRequest();
    }

    /**
     * Every controller should implement the method for index action at least
     * @return Response
     */
    public abstract function index();
}