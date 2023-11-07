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

//Get the template parameters
$templates = array_filter(scandir("/var/www/PiBakery/writable/templates/"), "parent_filter");
$return_templates = array();

foreach ($templates as $template) {
	$directory = "/var/www/PiBakery/writable/templates/" . $template . "/";
	$file_name = $directory . "params.json";

	if (file_exists($file_name)) {
		$param_json = file_get_contents($directory . "params.json");
		array_push($return_templates, array(
			"template_name" => $template,
			"params" => json_decode($param_json)
		));
	} else {
		array_push($return_templates, array(
			"template_name" => $template,
			"params" => null
		));
	}
}

echo json_encode($return_templates);