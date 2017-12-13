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
			
.buttsty {
   border-top: 1px solid #96d1f8;
   background: #65a9d7;
   background: -webkit-gradient(linear, left top, left bottom, from(#3e779d), to(#65a9d7));
   background: -webkit-linear-gradient(top, #3e779d, #65a9d7);
   background: -moz-linear-gradient(top, #3e779d, #65a9d7);
   background: -ms-linear-gradient(top, #3e779d, #65a9d7);
   background: -o-linear-gradient(top, #3e779d, #65a9d7);
   padding: 9.5px 19px;
   -webkit-border-radius: 8px;
   -moz-border-radius: 8px;
   border-radius: 8px;
   -webkit-box-shadow: rgba(0,0,0,1) 0 1px 0;
   -moz-box-shadow: rgba(0,0,0,1) 0 1px 0;
   box-shadow: rgba(0,0,0,1) 0 1px 0;
   text-shadow: rgba(0,0,0,.4) 0 1px 0;
   color: white;
   font-size: 16px;
   font-family: 'Lucida Grande', Helvetica, Arial, Sans-Serif;
   text-decoration: none;
   vertical-align: middle;
   }
.buttsty:hover {
   border-top-color: #28597a;
   background: #28597a;
   color: #ccc;
   }
.buttsty:active {
   border-top-color: #1b435e;
   background: #1b435e;
   }
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
 <a href="Home.php" class="w3-bar-item w3-button">Home</a>
  <a href="StreamPage.php" class="w3-bar-item w3-button">Stream</a>
  <a href="SearchPage.php" class="w3-bar-item w3-button">Search</a>
  
</div>
 
<div id="main">

<div class="w3-teal">
  <button style="padding-top: 27px;" id="openNav" class="w3-button w3-teal w3-xlarge" onclick="w3_open()">&#9776;</button>
  <img align="right" src="../Misc/CyberSymbol.png" alt="CyberStock" width="15%" height="10%">
  <div class="w3-container">
  </div>
</div>

<body onload="LoadSetup()" style="background: #e5f1ed;">
		<center>
			 <!-- START Worden Top Gainers and Losers Ticker Widget -->
			<script src="http://widgets.freestockcharts.com/js/jquery-1.3.1.min.js" type="text/javascript"></script> <script src="http://widgets.freestockcharts.com/script/WBIHorizontalTicker2.js?ver=12334" type="text/javascript"></script> <link href="http://widgets.freestockcharts.com/WidgetServer/WBITickerblue.css" rel="stylesheet" type="text/css" />
		<script>
    		var gainerTick = new WBIHorizontalTicker('gainers');
    		gainerTick.start();
    		var loserTick = new WBIHorizontalTicker('losers');
   			 loserTick.start();
		</script> <!-- End Scrolling Ticker Widget -->
			<img src="../Misc/stats.png"  width="50%" height="250">

									<!-- TradingView Widget BEGIN -->
				
				<p style= "font-family: impact; color: #000; font-size: 30px ">Select below to see statistics on your favorite account. </p>
<!-- TradingView Widget END -->

						<form action="Graph.php" method="POST" id="graphFrame" target="graph">
							<select name="gText">
								<option selected="selected">Choose One</option>
								<?php
									foreach ($FollowedNames as $name)	{
										echo '<option value="' . $name . '">' . $name . '</option>';
										ob_flush();
										flush();
									}
								?>
							</select>
							<!--
								The searchVisibility function toggles the display of the (streamFrame) and
								(searchFrame) form. Initially, the (searchFrame) is not displayed but
								(streamFrame) is. Pressing the button makes (searchFrame) visible and
								(streamFrame) not visible.
							-->

							<button class="buttsty" type="submit" value="Submit" 0000> Graph Account</button>
							<br><br><br>
							<!--
								All output from "Search.php" is output in the (searchOutput) frame.
							-->
							
							<iframe name="graph" id="graphOutput" frameborder="0"></iframe>
						</form>
		</center>
	</body>
</html>
