<?php
session_start();
//$_SESSION['Alert'] = "send";
$action = $_GET['action'];

$action();

function sendToCloud(){
	$url_array = explode('?', 'http://'.$_SERVER ['HTTP_HOST'].$_SERVER['REQUEST_URI']);
	$url = $url_array[0];

	require_once 'google-api-php-client/src/Google_Client.php';
	require_once 'google-api-php-client/src/contrib/Google_DriveService.php';
	$client = new Google_Client();
	$client->setClientId('176349010523-sltn4d89kj8998u3rj8glabgl8mq1luu.apps.googleusercontent.com');
	$client->setClientSecret('XQIORa7BS2UbCEUvXEX8Tn6z');
	$client->setRedirectUri($url);
	$client->setScopes(array('https://www.googleapis.com/auth/drive'));
	if (isset($_GET['code'])) {
		$_SESSION['accessToken'] = $client->authenticate($_GET['code']);
		header('location:'.$url);exit;
	} elseif (!isset($_SESSION['accessToken'])) {
		$client->authenticate();
	}
	$files= array();
	$dir = dir('../cloud');
	while ($file = $dir->read()) {
		if ($file != '.' && $file != '..') {
			$files[] = $file;
		}
	}
	$dir->close();
	if (!$_POST) {
		echo "a";
		$_SESSION['Alert'] = "send";
		$client->setAccessToken($_SESSION['accessToken']);
		$service = new Google_DriveService($client);
		$finfo = finfo_open(FILEINFO_MIME_TYPE);
		$file = new Google_DriveFile();
		foreach ($files as $file_name) {
			$file_path = 'cloud/'.$file_name;
			$mime_type = finfo_file($finfo, $file_path);
			$file->setTitle($file_name);
			$file->setDescription('This is a '.$mime_type.' document');
			$file->setMimeType($mime_type);
			$service->files->insert(
				$file,
				array(
					'data' => file_get_contents($file_path),
					'mimeType' => $mime_type
				)
				
			);
			exit;
		}
		finfo_close($finfo);
		header('location:'.$url);exit;
	}
}

?>