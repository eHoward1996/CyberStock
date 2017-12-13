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


		form{
			margin: auto;
			padding: auto;
			border: none;
			width: auto;
			height: auto;
		}
		</style>
		<?php include __DIR__. '../../Misc/Shared.php'; ?>
	</head>

	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="w3.css">
	

  <div class="w3-sidebar w3-bar-block w3-card w3-animate-left" style="display:none" id="mySidebar">
  <button class="w3-bar-item w3-button w3-large" onclick="w3_close()">Close &times;</button>
  <a href="Home.php" class="w3-bar-item w3-button">Home</a>
  <a href="SearchPage.php" class="w3-bar-item w3-button">Search</a>
  <a href="GraphPage.php" class="w3-bar-item w3-button">Statistical Analysis</a>
  
</div>
 
<div id="main">

<div class="w3-teal">
  <button  style="padding-top: 27px;" id="openNav" class="w3-button w3-teal w3-xlarge" onclick="w3_open()">&#9776;</button>
   <img align="right" src="../Misc/CyberSymbol.png" alt="CyberStock" width="15%" height="10%">
  <div class="w3-container">
  </div>
</div>
	<!--
		LoadSetup() submits the (streamFrame) form to start the stream on page load.
	-->
<body onload="LoadSetup()" style="background:#e5f1ed;">
		<center>
			 <!-- START Worden Top Gainers and Losers Ticker Widget -->
			<script src="http://widgets.freestockcharts.com/js/jquery-1.3.1.min.js" type="text/javascript"></script> <script src="http://widgets.freestockcharts.com/script/WBIHorizontalTicker2.js?ver=12334" type="text/javascript"></script> <link href="http://widgets.freestockcharts.com/WidgetServer/WBITickerblue.css" rel="stylesheet" type="text/css" />
		<script>
   			var gainerTick = new WBIHorizontalTicker('gainers');
    		gainerTick.start();
    		var loserTick = new WBIHorizontalTicker('losers');
   		 	loserTick.start();
		</script> <!-- End Scrolling Ticker Widget -->
			<br><br>

					<p "text-align: center;" style= "font-family: impact; color: #000; font-size: 30px ">Livestream of Tweets</p>
					<br><br>
						<!--
							When the page loads the (streamFrame) form is submitted, causing the initial
							stream to start. All output is put into the (streamOutput) iframe.
						-->
						<form action="Stream.php" method="POST" id="streamFrame" target="stream">
							<iframe style="background-color: #87c3eb70;" name="stream" id="streamOutput" frameborder="0"></iframe>
						</form>
					

		</center>
	</body>
</html>
