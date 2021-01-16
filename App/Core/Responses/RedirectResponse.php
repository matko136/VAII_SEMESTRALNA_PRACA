<?php


namespace App\Core\Responses;

use App\Config\Configuration;
use App\App;

class RedirectResponse extends Response
{
    private App $app;
    private $viewName;
    private $layoutName = Configuration::ROOT_LAYOUT;
    private $data;
    public function __construct($app, $viewName, $data)
    {
        $this->app = $app;
        $this->viewName = $viewName;
        $this->data = $data;
    }

    public function generate()
    {
        $data = $this->data;
        $authController = $this->app->getAuthController();

        require "App" . DIRECTORY_SEPARATOR . "Views" . DIRECTORY_SEPARATOR . $this->viewName . DIRECTORY_SEPARATOR . "index.view.php";

        $contentHTML = ob_get_clean();

        require "App" . DIRECTORY_SEPARATOR . "Views" . DIRECTORY_SEPARATOR . $this->layoutName;
    }
}