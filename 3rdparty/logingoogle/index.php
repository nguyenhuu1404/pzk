<?php
// Cau hinh Goolge API
$google_client_id 		= '126161793684-2gusjv590c5tsn5cfji6hi7siv7pilb7.apps.googleusercontent.com';
$google_client_secret 	= 'uzzOYEgxu9BvWKvE7YsShq8p';
$google_redirect_url 	= 'http://ptnn.vn/Account/logingoogle';
$google_developer_key 	= 'AIzaSyCot2ozarrxNUA8g6ZnX-dnsooigJ0sXRI';

/* ==========================================================================================================*/

require_once 'src/Google_Client.php';
require_once 'src/contrib/Google_Oauth2Service.php';
session_start();
$gClient = new Google_Client();
$gClient->setApplicationName('Đăng nhập bằng tài khoản Google');
$gClient->setClientId($google_client_id);
$gClient->setClientSecret($google_client_secret);
$gClient->setRedirectUri($google_redirect_url);
$gClient->setDeveloperKey($google_developer_key);
$google_oauthV2 = new Google_Oauth2Service($gClient);
if (isset($_REQUEST['reset'])) 
{
	unset($_SESSION['token']);
	$gClient->revokeToken();
	header('Location: ' . filter_var($google_redirect_url, FILTER_SANITIZE_URL));
}
if (isset($_GET['code'])) 
{ 
	$gClient->authenticate($_GET['code']);
	$_SESSION['token'] = $gClient->getAccessToken();
	header('Location: ' . filter_var($google_redirect_url, FILTER_SANITIZE_URL));
	return;
}
if (isset($_SESSION['token'])) 
{ 
	$gClient->setAccessToken($_SESSION['token']);
}
if ($gClient->getAccessToken()) 
{
	$user 				= $google_oauthV2->userinfo->get();
	$user_id 			= $user['id'];
	$user_name 			= filter_var($user['name'], FILTER_SANITIZE_SPECIAL_CHARS);
	$email 				= filter_var($user['email'], FILTER_SANITIZE_EMAIL);
	$profile_url 		= filter_var($user['link'], FILTER_VALIDATE_URL);
	$profile_image_url 	= filter_var($user['picture'], FILTER_VALIDATE_URL);
	$personMarkup 		= "$email<div><img src='$profile_image_url?sz=50'></div>";
	$_SESSION['token'] 	= $gClient->getAccessToken();
	
}
else 
{
	$authUrl = $gClient->createAuthUrl();
}
echo '<!DOCTYPE html>';
echo '<html>';
echo '<head>';
echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
echo '<title>Đăng nhập với Google</title>';
echo '</head>';
echo '<body>';
echo '<h1>Đăng nhập với Google</h1>';
if(isset($authUrl))
{
	echo '<a class="login" href="'.$authUrl.'"><img src="images/google-login-button.png" /></a>';
} 
else
{
	if($profile_image_url)
	{
		echo '<br /><a href="'.$profile_url.'" target="_blank"><img src="'.$profile_image_url.'?sz=128" /></a>';
	}
	echo '<br /><a class="logout" href="?reset=1">Thoát</a>';	
	echo '<pre>'; 
	print_r($user);
	echo '</pre>';	
} 
echo '</body></html>';
?>

