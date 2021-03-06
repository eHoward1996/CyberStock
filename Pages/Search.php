<html>
	<head>
		<!-- include links to CSS and JS Files -->
		<script><?php include 'mainScripts.js'; ?></script>
		<style> <?php include 'mainStyle.css';  ?></style>
	</head>
	<body>
		<div>
			<form action="../Misc/HandleFollowActions.php" method="POST" id="stream">
				<?php
					// Let the user know that even though they
					// might not immeadiately see resukts,
					// we are processing results.
					echo 'Loading stream for ' . $_POST['sText'] . '...';
					ob_flush();
					flush();

					// Get variables we need in all pages.
					include __DIR__. '../../Misc/Shared.php';

					// Persistant Variables from
					// "../Shared.php"
					$tweetStream = $stream;
					$companyList = $fortune5CompanyList;

					// When the stream returns a result
					// this function is called. We want to
					// extract the "Username" and "Text" from
					// the tweet. Then we want to print that
					// information.
					function streaming_callback(array $tweet) {
						$username = $tweet['user']['screen_name'];
						$text = $tweet['text'];

						printToScreen($username, $text);
					}

					// This starts the search stream. We want
					// to get results related to our search term
					// ($_POST['sText'])
					function startStream()	{
						$GLOBALS['tweetStream']->whenHears(
							$_POST['sText'],
							'streaming_callback'
						)->startListening();
					}

					startStream();
				?>
			</form>
			<span></span>
			<div class="loader"></div>
		</div>
	</body>
</html>
