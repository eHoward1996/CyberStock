<html>
	<head>
		<title>Twitter Fingerz</title>
		<?php
			// add links to external stylesheets and JavaScript
			echo "<link rel='stylesheet' type='text/css' href='mainStyle.css' />";
			echo "<script src='mainScripts.js'></script>"
		?>
	</head>

	<!--
		LoadSetup() submits the (streamFrame) form to start the stream on page load.
	-->
	<body onload="LoadSetup()" style="background-color: green; margin: 2% 5% 2% 5%;">
		<center>
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
				<button type="submit" value="Submit" onclick="searchVisibility()">Search Text</button>

				<br><br><br>

				<!--
					All output from "Search.php" is output in the (searchOutput) frame.
				-->
				<iframe name="search" id="searchOutput" frameborder="0"></iframe>
			</form>

			<!--
				When the page loads the (streamFrame) form is submitted, causing the initial
				stream to start. All output is put into the (streamOutput) iframe.
			-->
			<form action="StreamAccess.php" method="POST" id="streamFrame" target="stream">
				<iframe name="stream" id="streamOutput" frameborder="0"></iframe>
			</form>
		</center>
	</body>
</html>
