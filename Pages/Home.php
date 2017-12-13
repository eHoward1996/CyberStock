<html>
	<head>
		<title>CyberStock</title>
		<!-- include links to CSS and JS Files -->
		<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
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
		<style> <?php include 'mainStyle.css';  ?></style>
		<?php include __DIR__. '../../Misc/Shared.php'; ?>
	</head>
	<!--
		LoadSetup() submits the (streamFrame) form to start the stream on page load.
	-->

<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="w3.css">
	

  <div class="w3-sidebar w3-bar-block w3-card w3-animate-left" style="display:none" id="mySidebar">
  <button class="w3-bar-item w3-button w3-large" onclick="w3_close()">Close &times;</button>
  <a href="StreamPage.php" class="w3-bar-item w3-button">Stream</a>
  <a href="SearchPage.php" class="w3-bar-item w3-button">Search</a>
  <a href="GraphPage.php" class="w3-bar-item w3-button">Statistical Analysis</a>
  
</div>

<div id="main">

<div class="w3-teal">
  <button style="padding-top: 27px;" id="openNav" class="w3-button w3-teal w3-xlarge" onclick="w3_open()">&#9776;</button>
  <img align="right" src="../Misc/CyberSymbol.png" alt="CyberStock" width="15%" height="10%">
  <div class="w3-container">
  </div>
</div>


	<body onload="LoadSetup()" style="background: #dceae6;">
		<center>
			 <!-- START Worden Top Gainers and Losers Ticker Widget -->
			<script src="http://widgets.freestockcharts.com/js/jquery-1.3.1.min.js" type="text/javascript"></script> <script src="http://widgets.freestockcharts.com/script/WBIHorizontalTicker2.js?ver=12334" type="text/javascript"></script> <link href="http://widgets.freestockcharts.com/WidgetServer/WBITickerblue.css" rel="stylesheet" type="text/css" />
			<script>
    		var gainerTick = new WBIHorizontalTicker('gainers');
    		gainerTick.start();
    		var loserTick = new WBIHorizontalTicker('losers');
    		loserTick.start();
			</script> <!-- End Scrolling Ticker Widget -->
			<!--<img src="../Misc/CyberSymbol.png" alt="CyberStock" width="500px" height="17%"/>-->
			

		<div class="container">
  		<img src="../Misc/fs-banner.png"  width="100%" height="500">
  		<div class="center"></div>
		</div>
		
			<p "text-align: center;" style= "font-family: impact; color: #000; font-size: 30px ">Thank you for visitng our site. We have various features in order to help you make the best financial decisions! Check the sidebar to see the options availabe.</p>

			<p style= "font-family: Garamond; color: #000; font-size: 20px ">Created by: Jacuqes Dupre, Evan Howard, Aaron McLeod, Zora Moore, Dallas Thompson III, Zhanel Tucker.</p>


			<!--
			<div class="tabs">

				<div class="tab">
					<input type="radio" id="tab-1" name="tab-group-1" checked>
					<label for="tab-1">Stream</label>
					<div class="content">
						
							When the page loads the (streamFrame) form is submitted, causing the initial
							stream to start. All output is put into the (streamOutput) iframe.
						
						<form action="Stream.php" method="POST" id="streamFrame" target="stream">
							<iframe name="stream" id="streamOutput" frameborder="0"></iframe>
						</form>
					</div>
				</div>

				<div class="tab">
					<input type="radio" id="tab-2" name="tab-group-1">
					<label for="tab-2">Search</label>
					<div class="content">
						
							When the user submits (searchFrame) form, the program loads a stream based on the
							search term entered into the search box (sText). The form is submitted by pressing
							the button in the (searchFrame form).
						
						<form action="Search.php" method="POST" id="searchFrame" target="search">
							<button id="stopZ" onclick="stopSearch()">Stop</button>
							
							<input type="text" name="sText" style="width: 25%;">
					
							
								The searchVisibility function toggles the display of the (streamFrame) and
								(searchFrame) form. Initially, the (searchFrame) is not displayed but
								(streamFrame) is. Pressing the button makes (searchFrame) visible and
								(streamFrame) not visible.
							
							
							<button type="submit" value="Submit">Search Text</button>
							<br>
							
							
								All output from "Search.php" is output in the (searchOutput) frame.
							
							<iframe id="hideframe" name="search" id="searchOutput" frameborder="0"></iframe>
						</form>
					</div>
				</div>

				<div class="tab">
					<input type="radio" id="tab-3" name="tab-group-1">
					<label for="tab-3">Graphs</label>
					<div class="content">
						<form action="Graph.php" method="POST" id="graphFrame" target="graph">
							<select name="gText">
								<option selected="selected">Choose One</option>

								/**There has to be < ? p h p right here
									foreach ($FollowedNames as $name)	{
										echo '<option value="' . $name . '">' . $name . '</option>';
										ob_flush();
										flush();
									}
								?>*/
							</select>
							
								The searchVisibility function toggles the display of the (streamFrame) and
								(searchFrame) form. Initially, the (searchFrame) is not displayed but
								(streamFrame) is. Pressing the button makes (searchFrame) visible and
								(streamFrame) not visible.
							
							<button type="submit" value="Submit">Graph Account</button>
							<br><br><br>
							
								All output from "Search.php" is output in the (searchOutput) frame.
							
							<iframe name="graph" id="graphOutput" frameborder="0"></iframe>
						</form>
					</div>
			   </div>
			</div>
		-->
		</center>
	</body>
</html>
