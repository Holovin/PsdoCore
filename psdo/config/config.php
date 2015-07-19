<?php
  define('ENVIRONMENT', 'dev');

  // dev
  if (ENVIRONMENT == 'development' || ENVIRONMENT == 'dev') {
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
  }

  // common
  define('URL_PROTOCOL', 'http://');
  define('URL_DOMAIN', $_SERVER['HTTP_HOST']);
  //define('URL', URL_PROTOCOL . URL_DOMAIN . URL_SUB_FOLDER);

  // database
  define('PSDO_CFG_DB_HOST', 'localhost');
  define('PSDO_CFG_DB_NAME', 'psdo');
  define('PSDO_CFG_DB_USER', 'psdo3ez');
  define('PSDO_CFG_DB_PASS', 'psdo3ez');