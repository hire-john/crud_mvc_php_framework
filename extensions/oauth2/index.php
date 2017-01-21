<?php

include('classes/oauth2.class.php');

$ga_setttings = array(
    "endpoint" => "https://accounts.google.com/o/oauth2/auth",
    "token_endpoint" => "https://accounts.google.com/o/oauth2/token",
    "client_id" => "770469683715.apps.googleusercontent.com",
    "client_secret" => "bbbrQ_7Lu4UjbvY6yN140x7D",
    "redirect_uri" => "http://mydev.foodcity.vic.com/docroot/oauth2callback",
    "scope" => "https://www.google.com/analytics/feeds/",
    "grant_type" => "authorization_code",
    "access_type" => "offline", // offline = request access token
    "approval_prompt" => "auto",
    "response_type" => "code"
);

$ga = new OAuth2($ga_setttings);
$ThisIsAnotherVariableWhoseSolePurposeIsToPausingTheDebuggerAndThatsAll = "value";

if(isset($_REQUEST['code'])){
var_dump($ga->accessToken);    
}else{
 echo "<a href=".$ga->requestResponse.">authorize</a>";
}


?>

