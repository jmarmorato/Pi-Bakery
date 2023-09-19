<?php echo view("Head"); ?>

<?php
$pis = Pi::get_pis();
?>

<?php echo view("Pis", array(
	"pis" => $pis
)
); ?>

<?php echo view("Foot"); ?>