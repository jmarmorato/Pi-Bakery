<?php echo view("Head"); ?>

<?php

switch ($_GET["error"]) {
	case 'missingPiName':
		$error_text = "The \"Name\" field cannot be left empty";
		break;
	case 'missingPiSerial':
		$error_text = "The \"Serial\" field cannot be left empty";
		break;
	case 'missingPiTemplate':
		$error_text = "You must select a template";
		break;
	case 'missingPiImage':
		$error_text = "You must select an image";
		break;
	case 'missingPiBootCidr':
		$error_text = "When using a static IP for netbooting, the \"IP Address\" field cannot be left empty";
		break;
	case 'missingPiBootGateway':
		$error_text = "When using a static IP for netbooting, the \"Gateway\" field cannot be left empty";
		break;
	case 'missingBootNetworkType':
		$error_text = "The \"Netboot Network Configuration\" field cannot be left empty";
		break;
	case 'missingPiOsCidr':
		$error_text = "When using a static IP for netbooting, the \"IP Address\" field cannot be left empty";
		break;
	case 'missingPiOsGateway':
		$error_text = "When using a static IP for netbooting, the \"Gateway\" field cannot be left empty";
		break;
	case 'missingPiOsNetworkType':
		$error_text = "The \"OS Network Configuration\" field cannot be left empty";
		break;
	case 'missingPiOsNetworkCidr':
		$error_text = "When using a static IP for the Pi OS, the \"IP Address\" field cannot be left empty";
		break;
	case 'missingPiOsNetworkGateway':
		$error_text = "When using a static IP for the Pi OS, the \"Gateway\" field cannot be left empty";
		break;
	default:
		$error_text = "Unknown Error";
		break;
}

?>

<?php echo view("Error", array("error" => $error_text)); ?>

<?php echo view("Foot"); ?>