<form id="return" action="../Pages/Home.php">
</form>

<?php
	require __DIR__. '../Shared.php';

	if (isset($_POST['user']) && isset($_POST['id']) && isset($_POST['action']))	{
		if ($_POST['action'] == "add")	{
			$GLOBALS['follow']->insertOne([
				"id" =>  $_POST['id'],
				"name" => "@" . $_POST['user']
			]);
			array_push($GLOBALS['FollowedNames'], $_POST['user']);
			array_push($GLOBALS['FollowedIDs'], $_POST['id']);
		}
		else {
			$GLOBALS['follow']->deleteOne([
				"id" =>  $_POST['id']
			]);
		}
	}
	echo "<script>document.getElementById('return').submit();</script>";
?>