<?php

/*
*	Take form data from /pis/new form and process
*/

require_once "../../app/init.php";

session_start();

if (!isset($_SESSION["account_id"])) {
  header("HTTP/1.1 401 Unauthorized");
  header("Location: /");
  exit;
}

if (!isset($_POST["piName"])) {
  header( 'HTTP/1.1 400 Bad Request' );
  echo "missing  piName ";
  exit;
}

if (!isset($_POST["piSerial"])) {
	header( 'HTTP/1.1 400 Bad Request' );
	echo "missing  piSerial ";
	exit;
}

if (!isset($_POST["piBootNetworkRadios"])) {
	header( 'HTTP/1.1 400 Bad Request' );
	echo "missing  piBootNetworkRadios ";
	exit;
}

if (!isset($_POST["piBootCidr"])) {
	header( 'HTTP/1.1 400 Bad Request' );
	echo "missing  piBootCidr ";
	exit;
}

if (!isset($_POST["piBootGateway"])) {
	header( 'HTTP/1.1 400 Bad Request' );
	echo "missing piBootGateway  ";
	exit;
}

if (!isset($_POST["piOSNetworkRadios"])) {
	header( 'HTTP/1.1 400 Bad Request' );
	echo "missing piOSNetworkRadios  ";
	exit;
}

if (!isset($_POST["piOSCidr"])) {
	header( 'HTTP/1.1 400 Bad Request' );
	echo "missing  piOSCidr ";
	exit;
}

if (!isset($_POST["piOSGateway"])) {
	header( 'HTTP/1.1 400 Bad Request' );
	echo "missing piOSGateway  ";
	exit;
}


if (!isset($_POST["piTemplate"])) {
	header( 'HTTP/1.1 400 Bad Request' );
	echo "missing  piTemplate ";
	exit;
}

$name = $_POST["piName"];
$serial = $_POST["piSerial"];
$template = $_POST["piTemplate"];
$image = $_POST["piImage"];

$boot_net_type = $_POST["piBootNetworkRadios"];
$boot_net_ip = $_POST["piBootCidr"];
$boot_net_gateway = $_POST["piBootGateway"];

$os_net_type = $_POST["piOSNetworkRadios"];
$os_net_ip = $_POST["piOSCidr"];
$os_net_gateway = $_POST["piOSGateway"];

$pi_id = Pi::new($name, $serial, $template, $image, $boot_net_type, $boot_net_ip,
	$boot_net_gateway, $os_net_type, $os_net_ip, $os_net_gateway);

require_once "provision_pi.php";

header("Location: /pis");