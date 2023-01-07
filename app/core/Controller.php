<?php 

class Controller 
{
    public function view($view, $data = []) 
    {
        require_once "../app/views/pages/" . $view . ".php";
    }
}