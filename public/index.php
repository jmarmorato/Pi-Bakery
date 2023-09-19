<?php

//This file is the entrypoint for the application.
require_once "../app/init.php";

session_start();

if (isset($_GET["page"])) {

	switch ($_GET["page"]) {
		case "login":
			require_once APPPATH . "/app/login.php";
			return;
		case "callback":
			require_once APPPATH . "/app/auth_callback.php";
			return;
		case "logout":
			require_once APPPATH . "/app/logout.php";
			return;
	}

	if (!isset($_SESSION["email"])) {
		header("Location: /login");
		return;
	}

	switch ($_GET["page"]) {
		case "dashboard":
			require_once APPPATH . "/app/Dashboard.php";
			break;
		case "pis":
			require_once APPPATH . "/app/Pis.php";
			break;
		case "new_pi":
			require_once APPPATH . "/app/New_Pi.php";
			break;
	}
} else {
	header("Location: /dashboard");
}