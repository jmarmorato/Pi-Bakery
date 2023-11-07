<?php

/*
*   This file initilizes the application.  Any global includes are defined here,
*   along with global function and variable definitions.
*/

/*
*   Make sure data submitted with jQuery AJAX call makes it to the $_POST
*   variable
*/
if ( $_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST) ) {
    $_POST = json_decode(file_get_contents('php://input'), true);
}

/*
*   Get application base path, and define constant APPPATH to point to the
*   absolute path to the installation.
*/
$base_path = __DIR__;
$path_array = explode("/", $base_path);
$app_path = "";

for ($i = 1; $i < count($path_array) - 1; $i++) {
  $app_path = $app_path . "/" . $path_array[$i];
}

define("APPPATH", $app_path);

/*
*   Setup logging to syslog
*/
//openlog("idea_compensate", LOG_PID | LOG_PERROR, LOG_SYSLOG);

/*
*   Include system files
*/
require_once APPPATH . "/system/view.php";
require_once APPPATH . "/system/helpers.php";

/*
*   Include external packages
*/
require_once APPPATH . "/vendor/autoload.php";

/*
 * Load configuration file and class
 */
$dotenv = Dotenv\Dotenv::createImmutable(realpath(__DIR__ . "/.."));
$dotenv->load();

/*
*   Include internal classes
*/
require_once APPPATH . "/app/classes/Authentication.php";
require_once APPPATH . "/app/classes/Configuration.php";
require_once APPPATH . "/app/classes/Database.php";
require_once APPPATH . "/app/classes/Pi.php";


$url = Configuration::url()["base_url"];

//Define the base URL of the application
define("BASEURL", $url);

/*
*   Include helper functions
*/
//require_once APPPATH . "/system/helpers.php";

?>
