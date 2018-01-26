<?php


	$db = require_once("db_connect.php");

	
	
	function isStakeIndexed($unitNo){
		
		global $db;
		
		$stmt = $db->prepare("SELECT * FROM stake WHERE stakeNo = ?");
		$stmt->execute(array($unitNo));
		$results = $stmt->fetchAll();
		
		if(count($results) > 0){
			return true;
		}else{
			return false;
		}
	}
	
	function getStakeMembers($stakeNo){
		
		global $db;
		
		$stmt = $db->prepare("SELECT * FROM person WHERE stakeNo = ? AND gender = 'FEMALE' ");
		$stmt->execute(array($stakeNo));
		$results = $stmt->fetchAll();
		
		$members;
		
		foreach($results as $person){
			
			$name = str_replace("'", "", $person["first_name"]);
		
			$mymember = array(
					"unitNo" => $person["unitNo"],
					"id"	=> $person["person_id"],
					"name" => $name,
					"gender" => $person["gender"],
					"photo" => "photos/".$person["person_id"].".jpg"
				);
				
			$members[] = $mymember;
				
				
		}
		
		shuffle($members);
		
		return $members;
		
	}

	function getWards($stakeNo){
		
		global $db;
		
		$stmt = $db->prepare("SELECT * FROM unit WHERE memberOf = ?");
		$stmt->execute(array($stakeNo));
		$results = $stmt->fetchAll();
				
		$wards;
		
		foreach($results as $ward){
		
			$myward = array(
					"unitNo" => $ward["unitNo"],
					"name" => $ward["unitName"],
					"value" => 0
				);
				
			$wards[] = $myward;
				
				
		}
		
		return $wards;
		
	}
	
	function getWardsReference($stakeNo){
		
		global $db;
		
		$stmt = $db->prepare("SELECT * FROM unit WHERE memberOf = ?");
		$stmt->execute(array($stakeNo));
		$results = $stmt->fetchAll();
				
		$wards;
		
		foreach($results as $ward){
		
			$myward = array(
					"unitNo" => $ward["unitNo"],
					"name" => $ward["unitName"],
					"value" => 0
				);
				
			$wards[$ward["unitNo"]] = $myward;
				
				
		}
		
		return $wards;
		
	}

	
	function insertPerson($personid,$firstname,$lastname, $unit, $stake, $gender){
		
		global $db;
		
		$stmt = $db->prepare("INSERT INTO person (person_id, first_name, last_name, unitNo, stakeNo, gender) VALUES (:id, :fname, :lname, :unit, :stake, :gender)");
		$stmt->bindParam(':id', $personid);
		$stmt->bindParam(':fname', $firstname);
		$stmt->bindParam(':lname', $lastname);
		$stmt->bindParam(':unit', $unit);
		$stmt->bindParam(':stake', $stake);
		$stmt->bindParam(':gender', $gender);
		
		$stmt->execute();
		
	}
	
	
	function insertUnit($unitNo, $unitName, $stakeNo){
		
		global $db;
		
		$stmt = $db->prepare("INSERT INTO unit (unitNo, unitName, memberOf) VALUES (:no, :name, :stake)");
		$stmt->bindParam(':no', $unitNo);
		$stmt->bindParam(':name', $unitName);
		$stmt->bindParam(':stake', $stakeNo);
		$stmt->execute();
		
	}
	
	function insertStake($unitNo, $unitName){
		
		global $db;
		
		$stmt = $db->prepare("INSERT INTO stake (stakeNo, stakeName) VALUES (:no, :name)");
		$stmt->bindParam(':no', $unitNo);
		$stmt->bindParam(':name', $unitName);
		$stmt->execute();
		
	}
	
	
?>