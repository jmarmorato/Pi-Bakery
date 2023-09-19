<?php echo view("Head"); ?>

<?php echo view("New_Pi", array(
	"images" => glob("/var/www/PiBakery/writable/images/*.img"),
	"templates" => array_filter(scandir("/var/www/PiBakery/writable/templates/"), "parent_filter")
)); ?>

<?php echo view("Foot"); ?>