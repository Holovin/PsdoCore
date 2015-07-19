<?php
  include '../psdo/config/config.php';

  try {
    $db = new PDO('mysql:host='.PSDO_CFG_DB_HOST.';'.'dbname='.PSDO_CFG_DB_NAME, PSDO_CFG_DB_USER, PSDO_CFG_DB_PASS);

    $db = $db->prepare("INSERT INTO test (testvalue) VALUES (1)");
    $db->execute();
    print "Seems ok";
  }

  catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
  }