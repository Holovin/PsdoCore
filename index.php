<?php
    require_once "Core/Init.php";

    use PSDO\Controller\BaseController;

    $b = new BaseController();

    echo '<html><body>';
    echo 'Debug: '.$b->test.'<br />';
    echo '<a href="dev_test/db_connect_test.php">Database connection test</a><br />';
    echo filter_input(INPUT_SERVER, 'DOCUMENT_ROOT')."<br />";
    echo __DIR__."<br />";
    echo $_SERVER['DOCUMENT_ROOT']."<br />";
    echo '</html></body>';