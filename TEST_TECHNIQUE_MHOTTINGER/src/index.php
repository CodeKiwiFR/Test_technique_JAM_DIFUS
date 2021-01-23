<?php
// Generating a constant value -> path to index.php
define("ROOT", str_replace("index.php", "", $_SERVER["SCRIPT_FILENAME"]));

// Importing main Controller and main Model and database config
require_once(ROOT . "config/database.php");
require_once(ROOT . "app/Model.php");
require_once(ROOT . "app/Controller.php");

// Importing phpQuery
require_once(ROOT . "lib/phpQuery/phpQuery.php");

// Splitting params from URL
$params = explode("/", $_GET["p"]);

// Does a param exist?
$controller = isset($params[0]) ? ($params[0] == "" ? "Home" : ucfirst($params[0])) : "Home";
$action = isset($params[1]) ? $params[1] : "index";

try {
    if (file_exists("controllers/" . $controller . ".php")) {
        require_once(ROOT."controllers/".$controller.".php");
        $controller = new $controller();
        if (method_exists($controller, $action)) {
            unset($params[0]);
            unset($params[1]);
            return call_user_func_array([$controller, $action], $params);
        }
    }
} catch (Exception $e) {
    // Dealing with server side raised exceptions
    http_response_code(444);
    $doc = phpQuery::newDocumentFilePHP(ROOT . "views/layouts/default.php");   
    $doc[".main-content"]->append(
        "<h1>Erreur: problème serveur.</h1>"
    );
    $doc[".main-content h1"]->addClass("main-content__title");
    print $doc->htmlOuter();
    return;
}
// When our route has not been found
http_response_code(404);
$doc = phpQuery::newDocumentFilePHP(ROOT . "views/layouts/default.php");   
$doc[".main-content"]->append(
    "<h1>Erreur: la page ne semble pas exister.</h1>"
);
$doc[".main-content h1"]->addClass("main-content__title");
print $doc->htmlOuter();