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

if (!isset($_POST["piName"]) || $_POST["piName"] == "") {
	header("Location: /error?error=missingPiName", TRUE, 303);
	exit;
}

if (!isset($_POST["piSerial"]) || $_POST["piSerial"] == "") {
	header("Location: /error?error=missingPiSerial", TRUE, 303);
	exit;
}

if (!isset($_POST["piBootNetworkRadios"])) {
	header("Location: /error?error=missingBootNetworkType", TRUE, 303);
	exit;
}

if ($_POST["piBootNetworkRadios"] == "static") {
	if (!isset($_POST["piBootCidr"]) || $_POST["piBootCidr"] == "") {
		header("Location: /error?error=missingPiBootCidr", TRUE, 303);
		exit;
	}

	if (!isset($_POST["piBootGateway"]) || $_POST["piBootGateway"] == "") {
		header("Location: /error?error=missingPiBootGateway", TRUE, 303);
		exit;
	}
}

if (!isset($_POST["piOSNetworkRadios"]) || $_POST["piOSNetworkRadios"] == "") {
	header("Location: /error?error=missingPiOsNetworkType", TRUE, 303);
	echo "missing piOSNetworkRadios  ";
	exit;
}

if ($_POST["piOSNetworkRadios"] == "static") {
	if (!isset($_POST["piOSCidr"]) || $_POST["piOSCidr"] == "") {
		header("Location: /error?error=missingPiOsNetworkCidr", TRUE, 303);
		exit;
	}
	
	if (!isset($_POST["piOSGateway"]) || $_POST["piOSGateway"] == "") {
		header("Location: /error?error=missingPiOsNetworkGateway", TRUE, 303);
		exit;
	}
}

if (!isset($_POST["piTemplate"]) || $_POST["piTemplate"] == "") {
	header("Location: /error?error=missingPiTemplate", TRUE, 303);
	exit;
}

if (!isset($_POST["piImage"]) || $_POST["piImage"] == "") {
	header("Location: /error?error=missingPiImage", TRUE, 303);
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

$templateParams = $_POST["templateParams"];

$pi_id = Pi::new(
	$name,
	$serial,
	$template,
	$image,
	$boot_net_type,
	$boot_net_ip,
	$boot_net_gateway,
	$os_net_type,
	$os_net_ip,
	$os_net_gateway,
	$templateParams
);

require_once "provision_pi.php";

header("Location: /pis");