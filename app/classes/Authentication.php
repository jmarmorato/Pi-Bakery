<?php

use Jumbojett\OpenIDConnectClient;

class Authentication {

    private $oidc = null;

    public function __construct() {
	$config = Configuration::auth();

	//This function starts the authentication process with keycloak
	$oidc = new OpenIDConnectClient($config["realm_url"],
		$config["client_id"],
		$config["client_token"]);

	// For development mode only
	$oidc->setVerifyHost(false);
	$oidc->setVerifyPeer(false);

	$oidc->setRedirectURL($config["redirect_url"]);
	$oidc->providerConfigParam(array('authorization_endpoint' => $config["endpoints"]["authorization"]));
	$oidc->providerConfigParam(array('end_session_endpoint' => $config["endpoints"]["end_session"]));
	$oidc->providerConfigParam(array('userinfo_endpoint' => $config["endpoints"]["userinfo"]));
	$oidc->providerConfigParam(array('token_endpoint' => $config["endpoints"]["token"]));
	$oidc->providerConfigParam(array('jwks_uri' => $config["endpoints"]["jwks"]));
	$oidc->addScope('email');
	$oidc->addScope('profile');
	$oidc->addScope('openid');
	$oidc->getAuthParams();

	$this->oidc = $oidc;
    }

    public function authenticate() {
	try {
	    $this->oidc->authenticate();
	} catch (Exception $e) {
	    header("Location: /pis");
	    error_log($e);
	    header("HTTP/1.1 500 Internal Server Error");
	    exit;
	}
    }
    
    public function getOidcObject() {
	return $this->oidc;
    }

    public function checkFirstLogin($first_name, $last_name, $email) {

	$current_time = time();
	$trial_end = $current_time + 60 * 60 * 24 * 30 * 4;
	
	try {
	    $db = new Database();
	    $db->connect();

	    //Check to see if this account is already in the accounts table
	    $sql = "SELECT `id` FROM accounts WHERE `email`=:email";
	    $statement = $db->db->prepare($sql);
	    $statement->bindParam(":email", $email);
	    $statement->execute();
	    $result = $statement->fetchColumn();
	    $count = $statement->rowCount();

	    if (!$count) {
				
		//Need to add this account to the database
		$sql = "INSERT INTO accounts (`email`, `first_name`, `last_name`, `created`) VALUES (:email, :first_name, :last_name, :created);";
		$create_statement = $db->db->prepare($sql);
		$create_statement->bindParam(":email", $email);
		$create_statement->bindParam(":first_name", $first_name);
		$create_statement->bindParam(":last_name", $last_name);
		$create_statement->bindParam(":created", $current_time);
		$create_result = $create_statement->execute();
		$count = $create_statement->rowCount();
		$account_insert_id = $db->db->lastInsertId();

		return array(
		    "account_id" => $account_insert_id,
		    "first_login" => true
		);
	    } else {
		return array(
		    "account_id" => $result,
		    "first_login" => false
		);
	    }
	} catch (PDOException $e) {
	    error_log($e);
	    header("HTTP/1.1 500 Internal Server Error");
	    exit;
	}
    }

    public function logout() {
	$config = Configuration::auth();

	$id_token = $_SESSION["id_token"];
	$this->oidc->setRedirectURL($config["post_logout_redirect_url"]);
	
	session_destroy();

	return $this->oidc->signOut($id_token, $config["post_logout_redirect_url"]);
    }

}

?>
