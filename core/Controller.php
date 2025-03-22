<?php

namespace Core;

class Controller {
    protected function view($view, $data = []) {
        extract($data);
        require_once "../views/" . $view . ".php";
    }

    protected function model($model) {
        require_once "../models/" . $model . ".php";
        $className = "Models\\" . $model;
        return new $className();
    }
}
