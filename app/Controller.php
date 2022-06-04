<?php

abstract class Controller
{
    public function render(string $view, array $data = [])
    {
        ob_start();
        require_once(ROOT . 'views/' . strtolower(get_class($this)) . '/' . $view . '.php');
        $content = ob_get_clean();
        require_once(ROOT . 'views/layout/default.php');
    }

    public function loadModel(string $model)
    {
        require_once(ROOT . 'models/' . $model . '.php');
        $this->$model = new $model();
    }
}