<?php
// Our shop controller
class Shop extends Controller {
    // GET /shop/
    public function index() {
        // Retrieving the Model and getting all the devs from database
        $this->loadModel("Dev");
        $devs = $this->Dev->getAll();

        // Loading templates using phpQuery
        $doc = phpQuery::newDocumentFilePHP(ROOT . "views/layouts/default.php");

        // Creating our page
        $container = phpQuery::newDocumentFilePHP(ROOT . "views/layouts/shopActions.php");
        $container->append("<div class=\"container\"></div>");

        // Appending our devs
        $container[".container"]->append($this->makeDevTemplate($devs));
        $doc[".main-content"]->append($container);

        // Importing the scripts
        $doc["head"]->append("<script src=\"/public/scripts/popup.js\" defer></script>");
        $doc["head"]->append("<script src=\"/public/scripts/range.js\" defer></script>");
        print $doc->htmlOuter();
    }

    // DELETE /shop/delete/id
    public function delete($id) {
        $clean_id = htmlspecialchars($id);
        if (!is_numeric($id)) {
            return $this->ajaxError();
        }
        $this->loadModel("Dev");
        $dev = $this->Dev->getOne($id);
        if (!$dev) {
            return $this->ajaxError();
        }
        $this->Dev->deleteOne($id);
        $response_array[] = array(
            'status' => 'ok', 'id' => $id, 'message' => 'Développeur effacé.'
        );
        echo json_encode($response_array);
    }

    // GET /shop/details/id
    public function details($id) {
        $content = phpQuery::newDocumentFilePHP(ROOT . "views/layouts/devDetails.php");
        $clean_id = htmlspecialchars($id);

        if (!is_numeric($id)) {
            return $this->ajaxError();
        }

        // Getting dev infos and putting them into our template
        $this->loadModel("Dev");
        $dev = $this->Dev->getOne($id);
        if (!$dev) {
            return $this->ajaxError();
        }
        $content[".details__title"] = $dev["dev_name"];
        $content[".details__price"] = $dev["dev_price"] . "€";
        $content[".details__description"] = $dev["dev_description"];
        $content[".details__img"]->attr("src", $dev["dev_imageUrl"]);

        // Getting dev languages and putting them into our template
        $langs = $this->Dev->getLang($id);
        foreach ($langs as $lang) {
            $content["ul"]->append("<li>" . $lang["lang_name"] . "</li>");
        }
        // die();
        $response_array[] = array(
            'status' => 'ok', 'content' => $content->html()
        );
        echo json_encode($response_array);
    }

    // GET /shop/price/price
    public function price($price) {
        $clean_price = htmlspecialchars($price);

        if (!is_numeric($price)) {
            return $this->ajaxError();
        }
        // Retrieving the Model and getting all the devs from database
        $this->loadModel("Dev");
        $devs = $this->Dev->getAllByPrice($clean_price);
        $doc = $this->makeDevTemplate($devs);
        $response_array[] = array(
            'status' => 'ok', 'content' => $doc->html()
        );
        echo json_encode($response_array);
    }

    // Generates the dev template -> every dev has a div
    private function makeDevTemplate($devs) {        
        // Putting the devs into the page using devTemplate
        $containerContent = phpQuery::newDocument();
        foreach ($devs as $dev) {
            $temp = $this->getDevTemplate($dev["dev_id"], $dev["dev_name"], $dev["dev_price"]);
            $containerContent->append($temp);
        }
        return $containerContent;
    }

    // For one dev, it fills the dev info template with given argument
    private function getDevTemplate($id, $name, $price) {
        $devTemplate = phpQuery::newDocumentFilePHP(ROOT . "views/layouts/devShop.php");

        $devTemplate[".devThumb-name"] = $name;
        $devTemplate[".devThumb-price"] = $price . "€";
        $devTemplate["form"]->append(
            '<input type="hidden" name="dev_id" value="' . $id . '">'
        );
        return $devTemplate;
    }

    // When AJAX request is not valid, this is what the server returns
    private function ajaxError() {
        $response_array[] = array(
            'status' => 'error', 'message' => 'Erreur, données invalides.'
        );
        echo json_encode($response_array);
    }
}