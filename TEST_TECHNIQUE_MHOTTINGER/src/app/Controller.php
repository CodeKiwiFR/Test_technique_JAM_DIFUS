<?php
// This class will be implemented by all our controllers
abstract class Controller {
    // Enables to load the controller associated model
    public function loadModel(string $model) {
        require_once(ROOT . "models/" . $model . ".php");
        $this->$model = new $model();
    }

    // This is for rendering -> useless because I decided to render using PHPQuery
    public function render(string $file, array $data = []) {
        extract($data);

        // Starting buffer
        ob_start();
        require_once(ROOT . "views/" . strtolower(get_class($this)) . "/" . $file . ".php");
        $content = ob_get_clean();
        require_once(ROOT . "views/layouts/default.php");
    }
}