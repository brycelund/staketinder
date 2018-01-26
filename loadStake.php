<?php
	
		set_time_limit(300);
		
		if(!isset($_SESSION)){session_start();}


		require("vendor/autoload.php");
		require_once("db_functions.php");


		getAllStakeMembers();
		getPhotos();
		getGirlStakeMembers();	
		
		
			$newWardList = array();
			$referenceWardList = array();
			//echo "-----------------";
			foreach($WardList as $ward){
				//print_r($ward);
				$id = $ward['unitNumber'];
					  $ward['value'] = 0;
				$newWardList[] = $ward;
				$referenceWardList[$id] = $ward;
			}
			//die(print_r($newWardList,true));
			$_SESSION['warddata'] = $newWardList;
			$_SESSION['warddatareference'] = $referenceWardList;	
			
			
			
			
			
			
	function getAllStakeMembers(){
		
		global $WardList, $StakeMembers, $stakeID;
			
		foreach($WardList as $ward){
			$wardmembers = getMembersOfWard($ward['unitNumber']);
			foreach($wardmembers as $member){
				$tmpmember = (array) $member;
				$hoh = (array) $tmpmember["headOfHouse"];
				$mymember = array(
					"unitNo" => $tmpmember["unitNo"],
					"id"	=> $hoh["individualId"],
					"name" => $hoh["directoryName"],
					"gender" => $hoh["gender"],
					"photo" => ""
				);
				insertPerson($hoh["individualId"],$hoh["directoryName"],"",$tmpmember["unitNo"],$stakeID,$hoh["gender"]);
				$StakeMembers[$hoh["individualId"]] = $mymember;
			}
			
		}	
		
	}
	
	
	
	function getMembersOfWard($unitNumber){
		
		global $client, $WardList, $API_endpoints;
		
		$endpoint = "https://www.lds.org/mobiledirectory/services/web/v3.0/mem/member-list/%@";
		$endpoint = str_replace("%@",$unitNumber,$endpoint);
		
		$res = $client->request('GET', $endpoint);
		$response = $res->getBody();	
		$jsonlist = json_decode($response);
		
		return $jsonlist;
	}



	function getPhotos(){
		
		global $StakeMembers, $client, $WardList;
		
		foreach($WardList as $ward){

			$endpoint = "https://www.lds.org/mobiledirectory/services/web/v3.0/photo/wardDirectory/photos/%@";
			$endpoint = str_replace("%@",$ward["unitNumber"],$endpoint);
			
			$res = $client->request('GET', $endpoint);
			$response = $res->getBody();	
			$jsonlist = (array) json_decode($response);
			
			$jsonlist = $jsonlist["memberPhotoInfo"];
			
			foreach($jsonlist as $tmpperson){

				$person = (array) $tmpperson;
				$id = $person["individualId"];
				$StakeMembers[$id]["photo"] = $person["imageUri"];
				
				try{
					$client->request('GET', $person["imageUri"], ['sink' => "photos/".$id.".jpg"]);
				}catch(Exception $e){
					
				}

			}
			
		}
		
		//
	}



	function getGirlStakeMembers(){
		
		global $StakeMembers, $girlStakeMembers;
		
		foreach($StakeMembers as $member){
			
			if($member['gender'] == "FEMALE" && $member['photo'] != ""){
				$girlStakeMembers[] = $member;
			}
			
			
		}
		
	}

	
?>