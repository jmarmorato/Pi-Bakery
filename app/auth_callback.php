<?php

$auth = new Authentication();
$auth->authenticate();
$oidc = $auth->getOidcObject();

$first_name = $oidc->requestUserInfo('given_name');
$last_name = $oidc->requestUserInfo('family_name');
$email = $oidc->requestUserInfo('email');
$verified = $oidc->requestUserInfo('verified');
$username = $oidc->requestUserInfo('preferred_username');

$first_login = $auth->checkFirstLogin($first_name, $last_name, $email, $verified);

$account_id = $first_login["account_id"];

$_SESSION["first_name"] = $first_name;
$_SESSION["last_name"] = $last_name;
$_SESSION["email"] = $email;
$_SESSION["verified"] = $verified;
$_SESSION["account_id"] = $account_id;
$_SESSION["username"] = $username;
$_SESSION["id_token"] = $oidc->getIdToken();

if($first_login["first_login"]) {
  header("Location: /pis?firstlogin=true");
} else {
  header("Location: /pis");
}

?>
