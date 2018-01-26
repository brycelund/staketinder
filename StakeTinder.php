<?php
	
	set_time_limit(300);
	
	if(!isset($_SESSION)){session_start();}
	
	require("vendor/autoload.php");
	require_once("db_functions.php");
	
	$username = $_SESSION["username"];
	$password = $_SESSION["password"];
	
	$API_endpoints = array();
	$WardList = array();
	$StakeMembers = array();
	$girlStakeMembers = array();
	$stakeID;	

	$client = new GuzzleHttp\Client(['cookies'=>true]);
	$_SESSION["myclient"] = $client;
	
	
	getAPIList();
	Authenticate();
	
	if(!getListOfWards()){
		
		include("loadStake.php");
		
		echo "We're loading in your stake now. Please come back in 10 minutes to view your Stake Tinder.";
		
	}else{
		$_SESSION['StakeMembers'] = getStakeMembers($stakeID);
		
		$_SESSION['warddata'] = getWards($stakeID);
		$_SESSION['warddatareference'] = getWardsReference($stakeID);
		
		
		//print_r($_SESSION['StakeMembers']);
		//die();
	}
	
	//$_SESSION['StakeMembers'] = $girlStakeMembers;
	
	
	//echo "<pre>";
	//print_r($WardList);


	
	
	/*
		
		array(
				'query' => [
					    'username' => $username,
					    'password' => $password
					    ]
				)
				
				*/
	
	
	
	
	
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
	}
	
	
	function getListOfWards(){
		
		global $client, $WardList, $API_endpoints, $stakeID;
		
		$endpoint = $API_endpoints["stake-units"];
		
		$res = $client->request('GET', $endpoint);
		$response = $res->getBody();	
		$jsonlist = json_decode($response);
		
		$tmparray = (array) $jsonlist[0];
		$stakeNo = $tmparray["areaUnitNo"];
		$stakeName = $tmparray["stakeName"];
		$stakeID = $tmparray["areaUnitNo"];
		
		if(!isStakeIndexed($stakeID)){
		
			insertStake($stakeNo,$stakeName);
			
			foreach($jsonlist as $tmpward){
				$ward = (array) $tmpward;
				
				insertUnit($ward["wardUnitNo"],$ward["wardName"],$stakeID);
				
				$WardList[] = array(
									"name"=>$ward["wardName"],
									"unitNumber" => $ward["wardUnitNo"]
									);
			}	
			
			return false;
		
		}else{
			return true;
		}
	}
	
	

	
	
?>