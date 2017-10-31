<html>
	<head>
		<title>Twitter Fingerz</title>
		<?php
			// add links to external stylesheets and JavaScript
			echo "<script src='../Pages/mainScripts.js'></script>"
		?>
	</head>
	<style><?php include 'mainStyle.css'; ?></style>
	<!--
		LoadSetup() submits the (streamFrame) form to start the stream on page load.
	-->
	<body onload="LoadSetup()" style="background: linear-gradient(white, #0086b3);">
		<center>
			<img src="../Misc/CyberSymbol.png" alt="CyberStock" width="500px" height="17%"/>
			<div class="tabs">
				<div class="tab" onclick="LoadSetup()">
					<input type="radio" id="tab-1" name="tab-group-1" checked>
					<label for="tab-1">Stream</label>
					<div class="content">
						<!--
							When the page loads the (streamFrame) form is submitted, causing the initial
							stream to start. All output is put into the (streamOutput) iframe.
						-->
						<form action="StreamAccess.php" method="POST" id="streamFrame" target="stream">
							<iframe name="stream" id="streamOutput" frameborder="0"></iframe>
						</form>
					</div>
				</div>
				<div class="tab">
					<input type="radio" id="tab-2" name="tab-group-1">
					<label for="tab-2">Search</label>
					<div class="content">
						<!--
							When the user submits (searchFrame) form, the program loads a stream based on the
							search term entered into the search box (sText). The form is submitted by pressing
							the button in the (searchFrame form).
						-->
						<form action="Search.php" method="POST" id="searchFrame" target="search">
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
					</div>
				</div>
				<div class="tab">
					<input type="radio" id="tab-3" name="tab-group-1">
					<label for="tab-3">Graphs</label>
					<div class="content">

					</div>
			   </div>
			</div>
		</center>
	</body>
</html>
