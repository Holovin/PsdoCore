<?php
    require_once "PSDO/Core/Init.php";

    use PSDO\Core\Application;
    use PSDO\Config;
    use PSDO\Controller\BaseController;
    use PSDO\Storage\Database;

    use PSDO\View\Document;
    use PSDO\View\Widget;
    use PSDO\View\Documents\HtmlDocument;

    $doc = HtmlDocument::getInstance();

    $doc->writeRaw('Request data:<br />');
    ob_start();
    var_dump($_REQUEST);
    $doc->writeRaw(ob_get_clean());
    $doc->writeRaw('<hr />Links:<br />');
    $doc->writeRaw('<a href="PSDO/Tests/db_connect_test.php">Database connection test</a><hr />');

    $doc->setTitle("PSDO!");
    $doc->render();