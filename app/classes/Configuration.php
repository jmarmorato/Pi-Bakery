<?php

class Configuration {

    public static function url() {
	return array(
	    "base_url" => $_ENV['BASE_URL']
	);
    }

    public static function auth() {
	$auth_config = array(
	    "client_id" => $_ENV['CLIENT_ID'],
	    "client_token" => $_ENV['CLIENT_TOKEN'],
	    "realm_url" => $_ENV['REALM_URL'],
	    "redirect_url" => $_ENV['BASE_URL'] . $_ENV['CALLBACK_URL'],
	    "post_logout_redirect_url" => $_ENV['BASE_URL'] . $_ENV['POST_LOGOUT_URL'],
	    "endpoints" => array(
		"end_session" => $_ENV['END_SESSION'],
		"authorization" => $_ENV['AUTHORIZATION'],
		"userinfo" => $_ENV['USERINFO'],
		"token" => $_ENV['TOKEN'],
		"delete_account_tok" => $_ENV['MASTER_T'],
		"jwks" => $_ENV['JWKS'],
	    )
	);

	return $auth_config;
    }

    public static function db() {
	return array(
	    "host" => $_ENV['DB_HOST'],
	    "user" => $_ENV['DB_USER'],
	    "pass" => $_ENV['DB_PASS'],
	    "schema" => $_ENV['DB_SCHEMA']
	);
    }

}
