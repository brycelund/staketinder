<?php

	session_start();

	if(isset($_POST['usr'])){
		$_SESSION['username'] = $_POST['usr'];
		$_SESSION['password'] = $_POST['pas'];
		header('Location: http://staketinder.com/play.php');
	}


?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>Login - Stake Tinder</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="stylesheet" href="assets/css/main.css" />
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
						<h1>Login</h1>
						<p>Log in to Stake Tinder using your LDS Account</p>
					</header>
					<form action="login.php" method="post">
						<input type="text" name="usr" placeholder="Username"/>
						<br/>
						<input type="password" name="pas" placeholder="Password"/>
						<br/>
						<center><input type="submit" value="Login" class="align-center"/></center>
					</form>
				</div>
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
