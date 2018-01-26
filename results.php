<?php
	
	/*session_start();
	
	$stakemembers = $_SESSION['StakeMembers'];*/
	
	$stakemembers = array(
			[
				"name" => "name1",
				"value" => 0
			],
			[
				"name" => "name2",
				"value" => 0
			],
			[
				"name" => "name3",
				"value" => 0
			],
			
	);

	echo "<pre>";
	echo json_encode($stakemembers);

	
?>