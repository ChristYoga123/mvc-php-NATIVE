<?php

class App {
    // Default Controller & Method & Adding Params if exists
    protected $controller = "Home";
    protected $method = "index";
    protected $parameter = [];

    // Construct Method for Routing
    public function __construct()
    {
        $url = $this->parseURL();
        if(isset($url[0]))
        {
            // Set First Value of Url 0 to Capital
            $controller_file = ucfirst($url[0]);
            if(file_exists("../app/controllers/" . $controller_file. "Controller.php")) 
            {
                // Replace Default Controller if file exists
                $this->controller = $controller_file;
                unset($url[0]);
            }
        }

        require_once "../app/controllers/" . $this->controller . "Controller.php";

        // Concate with string "Controller" {Home -> HomeController}
        $controller = $this->controller . "Controller";
        $this->controller = new $controller;

        if(isset($url[1]))
        {
            if(method_exists($controller, $url[1]))
            {
                $this->method = $url[1];
                unset($url[1]);
            }
        }
        if(!empty($url))
        {
            $this->parameter = array_values($url);
        }

        // Run Controller, Method, and Send Parameter if exists
        call_user_func_array([$this->controller, $this->method], $this->parameter);
    }

    // Method for Parsing URL to Routing
    private function parseURL()
    {
        if(isset($_GET["url"]))
        {
            $url = rtrim($_GET["url"], "/");
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode("/", $url);
            return $url;
        }
    }

}

?>