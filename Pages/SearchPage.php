<html>
	<head>
		<title>CyberStock</title>
		<!-- include links to CSS and JS Files -->
		<script><?php include 'mainScripts.js'; ?>

			
			function w3_open() {
    document.getElementById("mySidebar").style.display = "block";
    document.getElementById("main").style.marginLeft = "25%";
    document.getElementById("mySidebar").style.width = "25%";
    document.getElementById("openNav").style.display = 'none';
}
function w3_close() {
    document.getElementById("mySidebar").style.display = "none";
    document.getElementById("main").style.marginLeft = "0%";
    document.getElementById("openNav").style.display = "inline-block";
}

function openNav() {
    document.getElementById("sideNavigation").style.width = "250px";
    document.getElementById("main").style.marginLeft = "250px";
}
 
function closeNav() {
    document.getElementById("sideNavigation").style.width = "0";
    document.getElementById("main").style.marginLeft = "0";
}

		</script>
		<style> <?php include 'mainStyle.css';  ?>

		</style>
		<?php include __DIR__. '../../Misc/Shared.php'; ?>
	</head>
	<!--
		LoadSetup() submits the (streamFrame) form to start the stream on page load.
	-->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="w3.css">
	

  <div class="w3-sidebar w3-bar-block w3-card w3-animate-left" style="display:none" id="mySidebar">
  <button class="w3-bar-item w3-button w3-large" onclick="w3_close()">Close &times;</button>
  <a href="http://localhost/src_tf/CyberStock/Pages/Home.php" class="w3-bar-item w3-button">Home</a>
  <a href="http://localhost/src_tf/CyberStock/Pages/StreamPage.php" class="w3-bar-item w3-button">Stream</a>
  <a href="http://localhost/src_tf/CyberStock/Pages/GraphPage.php" class="w3-bar-item w3-button">Statistical Analysis</a>
  
</div>
 
<div id="main">

<div class="w3-teal">
  <button id="openNav" class="w3-button w3-teal w3-xlarge" onclick="w3_open()">&#9776;</button>
  <div class="w3-container">
  </div>
</div>
<body onload="LoadSetup()" style="background: linear-gradient(white, #0086b3);">
		<center>
			<img src="../Misc/CyberSymbol.png" alt="CyberStock" width="500px" height="20%"/>

		
				
						<!--
							When the user submits (searchFrame) form, the program loads a stream based on the
							search term entered into the search box (sText). The form is submitted by pressing
							the button in the (searchFrame form).
						-->
						
							<form action="Search.php" method="POST" id="searchFrame" target="search">
							<button onclick="ChangeVal()">Stop</button>
							<input type="text" name="sText" style="width: 25%;">
							<!--
								The searchVisibility function toggles the display of the (streamFrame) and
								(searchFrame) form. Initially, the (searchFrame) is not displayed but
								(streamFrame) is. Pressing the button makes (searchFrame) visible and
								(streamFrame) not visible.
							-->
							<button type="submit" value="Submit">Search Text</button>
							<br>
							<!--
								All output from "Search.php" is output in the (searchOutput) frame.
							-->
							<iframe name="search" id="searchOutput" frameborder="0"></iframe>
						</form>
				
		</center>
	</body>
</html>
