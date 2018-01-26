<?php
	
	session_start();
	
	require("StakeTinder.php");
	
	$stakemembers = $_SESSION['StakeMembers'];
	$warddata = $_SESSION['warddata'];
	$warddata_ref = $_SESSION['warddatareference'];
	$wards = json_encode($warddata);
	$wards_ref = json_encode($warddata_ref);
	
	$data = json_encode($stakemembers);	
?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>Stake Tinder</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<style>
		#chartdiv {
		  width: 100%;
		  height: 500px;
		  margin: auto;
		}	
		</style>
		<script>
		
		    stakemembers = JSON.parse('<?=$data?>');
			
			current_person = 0;
			
		    wards = JSON.parse('<?=$wards?>'); //JSON.parse('{"10308":{"name":"Provo YSA 196th Ward","unitNumber":10308,"value":0},"10839":{"name":"Provo YSA 197th Ward","unitNumber":10839,"value":0},"75019":{"name":"Provo YSA 198th Ward","unitNumber":75019,"value":0},"74837":{"name":"Provo YSA 199th Ward","unitNumber":74837,"value":0},"91189":{"name":"Provo YSA 200th Ward","unitNumber":91189,"value":0},"161543":{"name":"Provo YSA 201st Ward","unitNumber":161543,"value":0},"194042":{"name":"Provo YSA 202nd Ward","unitNumber":194042,"value":0},"227870":{"name":"Provo YSA 203rd Ward","unitNumber":227870,"value":0},"227889":{"name":"Provo YSA 204th Ward","unitNumber":227889,"value":0},"270652":{"name":"Provo YSA 205th Ward","unitNumber":270652,"value":0},"275670":{"name":"Provo YSA 206th Ward","unitNumber":275670,"value":0},"413887":{"name":"Provo YSA 207th Ward","unitNumber":413887,"value":0}}
			
			 wards_ref = JSON.parse('<?=$wards_ref?>');
			
			function advancePerson(){
				current_person++;
				document.getElementById("current_profile_name").innerHTML = stakemembers[current_person]['name'];
				document.getElementById("current_profile_ward").innerHTML = wards_ref[stakemembers[current_person]['unitNo']]['name'];
				document.getElementById("current_profile_photo").src = stakemembers[current_person]['photo'];
				
				if(!imageExists(stakemembers[current_person]['photo'])){
					advancePerson();
				}
				
			}
			
			function yes(){
					advancePerson();
					
					for(var i=0;i<wards.length;i++){
						var id = wards[i]['unitNo'];
						if(id == stakemembers[current_person]['unitNo']){
							wards[i]['value'] = wards[i]['value']+1;
						}
					}
					
					chart.validateData();
				    /*$.ajax({
					  url: "recieve_input.php",
					  type: "post",
					  data: { 
					    person_id: stakemembers[current_person]["id"],
					    marked: "yes"
					  },
					  success: function(response) {
					    
					  },
					  error: function(xhr) {
					    //Do Something to handle error
					  }
					});*/
			}
			
			function no(){
					advancePerson();
				    /*$.ajax({
					  url: "recieve_input.php",
					  type: "post",
					  data: { 
					    person_id: stakemembers[current_person]["id"],
					    marked: "no"
					  },
					  success: function(response) {
					    
					  },
					  error: function(xhr) {
					    //Do Something to handle error
					  }
					});*/
			}
			
			
			function imageExists(image_url){

			    var http = new XMLHttpRequest();
			
			    http.open('HEAD', image_url, false);
			    http.send();
			
			    return http.status != 404;
			
			}
			
			//json_encode($stakemembers);
			
		</script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
		
		<script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
		<script src="https://www.amcharts.com/lib/3/serial.js"></script>
		<script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
		<link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
		<script src="https://www.amcharts.com/lib/3/themes/light.js"></script>
		
		<script>
	    chart = AmCharts.makeChart( "chartdiv", {
		  "type": "serial",
		  "theme": "light",
		  "dataProvider": wards,
		  "valueAxes": [ {
		    "gridColor": "#FFFFFF",
		    "gridAlpha": 0.2,
		    "dashLength": 0
		  } ],
		  "gridAboveGraphs": true,
		  "startDuration": 1,
		  "graphs": [ {
		    "balloonText": "[[category]]: <b>[[value]]</b>",
		    "fillAlphas": 0.8,
		    "lineAlpha": 0.2,
		    "type": "column",
		    "valueField": "value"
		  } ],
		  "chartCursor": {
		    "categoryBalloonEnabled": false,
		    "cursorAlpha": 0,
		    "zoomable": false
		  },
		  "categoryField": "name",
		  "categoryAxis": {
		    "gridPosition": "start",
		    "gridAlpha": 0,
		    "tickPosition": "start",
		    "tickLength": 20
		  },
		  "export": {
		    "enabled": true
		  }
		
		} );
		</script>
	</head>
	<body class="subpage">

		<!-- Header -->
			<header id="header">
				<nav class="left">
					<a href="#menu"><span>Menu</span></a>
				</nav>
				<a href="index.php" class="logo">Stake Tinder</a>
			</header>

		<!-- Menu -->
			<nav id="menu">
				<ul class="links">
					<li><a href="index.php">Home</a></li>
				</ul>
			</nav>

		<!-- Main -->
			<section id="main" class="wrapper">
				<div class="inner">
					<header class="align-center">
						<h1><div id="current_profile_name"></div></h1>
						<script>document.getElementById("current_profile_name").innerHTML = stakemembers[current_person]['name'];</script>
						<p><div id="current_profile_ward"></div></p>
						<script>document.getElementById("current_profile_ward").innerHTML = wards_ref[stakemembers[current_person]['unitNo']]['name'];</script>
						<img id="current_profile_photo" height="350px"/>
						<script>document.getElementById("current_profile_photo").src = stakemembers[current_person]['photo'];</script></p>
					</header>
					<center>
					<button class="big" style="font-size:25px;" onclick="no()">✖</button>
					<button class="big" style="font-size:25px;" onclick="yes()">✓</button>
					</center>
				</div>
			</section>
			
			<section id="two" class="wrapper">
				<div id="chartdiv"></div>	
			</section>

		<!-- Footer -->
			<footer id="footer">
				<!--<div class="inner">
					
					<h2>Get In Touch</h2>
					<ul class="actions">
						<li><span class="icon fa-phone"></span> <a href="#">(000) 000-0000</a></li>
						<li><span class="icon fa-envelope"></span> <a href="#">information@untitled.tld</a></li>
						<li><span class="icon fa-map-marker"></span> 123 Somewhere Road, Nashville, TN 00000</li>
					</ul>
				</div>
				<div class="copyright">
					&copy; Untitled. Design <a href="https://templated.co">TEMPLATED</a>. Images <a href="https://unsplash.com">Unsplash</a>.
				</div>-->
			</footer>

		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/jquery.scrolly.min.js"></script>
			<script src="assets/js/skel.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>

	</body>
</html>