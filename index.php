<?php
    require_once "PSDO/Core/Init.php";

    use PSDO\Core\Application;
    use PSDO\Config;
    use PSDO\Controller\BaseController;
    use PSDO\Storage\Database;

    $app = new Application();
    die();

    echo '<html><body>';
    echo 'Request data:<br />';
    var_dump($_REQUEST);
    echo '<hr />Links:<br />';
    echo '<a href="PSDO/Tests/db_connect_test.php">Database connection test</a><hr />';

    $dbh = Database::getInstance();
    $t = $dbh->getConnector();
    $stmt = $t->query('SELECT * FROM test');

    var_dump($stmt);

    echo "<hr />";

    while ($row = $stmt->fetch()) {
        print_r($row);
    }


    echo '</html></body>';