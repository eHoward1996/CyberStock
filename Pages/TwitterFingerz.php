<html>
	<head>
		<title>Twitter Fingerz</title>
		<?php
			echo "<link rel='stylesheet' type='text/css' href='mainStyle.css' />";
			echo "<script src='mainScripts.js'></script>"
		?>
	</head>

	<body onload="LoadSetup()">
		<center>
			<form action="Search.php" method="POST" id="searchFrame" target="search">
				<input type="text" name="sText" style="width: 25%;">
				<button type="submit" value="Submit" onclick="searchVisibility()">Search Text</button>

				<br><br><br>

				<iframe name="search" id="searchOutput" frameborder="0"></iframe>
			</form>
			<form action="StreamAccess.php" method="POST" id="streamFrame" target="stream">
				<iframe name="stream" id="streamOutput" frameborder="0"></iframe>
			</form>
		</center>


	</body>
</html>
