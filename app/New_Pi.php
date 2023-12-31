<?php

echo view("Head");

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

echo view("New_Pi", array(
	"images" => glob("/var/www/PiBakery/writable/images/*.img"),
	"templates" => $return_templates
));

echo view("Foot");

?>