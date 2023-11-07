<?php

/*
*	Take form data from /pis/new form and process
*/

require_once "../../app/init.php";

session_start();

if (!isset($_SESSION["account_id"])) {
  header("Location: /login");
  exit;
}

if (!isset($_GET["piId"])) {
  header( 'HTTP/1.1 400 Bad Request' );
  exit;
}

$piId = $_GET["piId"];
$pi = Pi::get_pi($piId)[0];

$serial=$pi["serial"];

$vars = <<<VARS
SERIAL=$serial
VARS;

file_put_contents(APPPATH . "/writable/delete/" . $serial, $vars);

Pi::delete($piId);

header("Location: /pis");
