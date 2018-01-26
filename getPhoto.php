<?php
	
	session_start();
	
	require("vendor/autoload.php");
	
	$username = "brycelund13";
	$password = "Welcome124";
	
	//$client = new GuzzleHttp\Client(['cookies'=>true]);
	$client = $_SESSION["myclient"];
	
	//getAPIList();
	//Authenticate();
	
	
	$id = $_GET['id'];


	$url = "https://www.lds.org/mobiledirectory/services/ludrs/1.1/photo/url/".$id."/individual";
	$res = $client->request('GET', $url);
	$response = $res->getBody();	
	$jsonlist = (array)json_decode($response);
	$file = $jsonlist["largeUri"];
	echo "<img src='".$file."' />";
	//$type = 'image/jpeg';
	//header('Content-Type:'.$type);
	//readfile($file);
	
	
	/*
	function getAPIList(){
		
		global $API_endpoints;
		
		$json_list = file_get_contents("https://tech.lds.org/mobile/ldstools/config.json");
		$API_endpoints = (array) json_decode($json_list);
		
	}
	
	function Authenticate(){
		
		global $client, $API_endpoints, $username, $password;
		
		$authurl = $API_endpoints["auth-url"];
		
		$res = $client->request('POST', $authurl, 
			array(
				'form_params' => [
					    'username' => $username,
					    'password' => $password
					    ]
				));
		if($res->getStatusCode() == "200"){
			//echo $res->getStatusCode();
			//echo $res->getBody();
			return true;
		}else{
			//echo $res->getStatusCode();
			//echo $res->getBody();
			return false;
		}
	}*/

	
	
?>