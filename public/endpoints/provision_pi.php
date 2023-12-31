<?php

require_once "../../app/init.php";

session_start();

if (!isset($_SESSION["account_id"])) {
	header("Location: /login");
  exit;
}

/*
*	The piID GET variable is set - get the required Pi information
*	provision.
*/

$reprovision = false;

if(!isset($pi_id)) {
	$pi_id = $_GET["piId"];
	$reprovision = true;

	if (!isset($_GET["piId"])) {
		header( 'HTTP/1.1 400 Bad Request' );
		exit;
	}
}

$pi = Pi::get_pi($pi_id)[0];

$serial=$pi["serial"];
$boot_net_type=$pi["boot_net_type"];
$boot_net_ip=$pi["boot_net_ip"];
$boot_net_gateway=$pi["boot_net_gateway"];
$image = $pi["image"];
$template = $pi["template"];

$template_params = Pi::get_template_parameters($serial);

$vars = <<<VARS
SERIAL="$serial"
BOOTNETTYPE="$boot_net_type"
BOOTNETIP="$boot_net_ip"
BOOTNETGATEWAY="$boot_net_gateway"
IMGPATH="/var/www/PiBakery/writable/images/$image"
TEMPLATE="/var/www/PiBakery/writable/templates/$template"
VARS;

foreach ($template_params as $param) {
	$key = strtoupper(explode("template-param-", $param["p_key"])[1]);
	$value = $param["p_value"];

	$vars = $vars . "\n$key=$value";
}

file_put_contents(APPPATH . "/writable/provision/" . $serial, $vars);

if ($reprovision) {
	header("Location: /pis");
}