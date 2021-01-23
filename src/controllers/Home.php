<?php
class Home extends Controller {
    // Displaying the welcome page
    public function index() {
        $doc = phpQuery::newDocumentFilePHP(ROOT . "views/layouts/default.php");
        
        $doc[".main-content"]->append(
            "<h1>Dev<span class=\"golden\">\$</span>ell: commerce de robots développeurs.</h1>"
        );
        $doc[".main-content"]->append(
            "<p>" . 
            "Le premier commerce de robots développeurs dans le Monde.<br>" .
            "En tant qu'administrateur, venez <a href=\"/shop\">gérer les robots de la boutique</a>." .
            "</p>"
        );
        $doc[".main-content h1"]->addClass("main-content__title");
        $doc[".main-content p"]->addClass("main-content__intro");
            
        print $doc->htmlOuter();
    }
}