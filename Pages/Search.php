<html>
	<head>
		<?php
			// add links to external stylesheets and JavaScript
			echo "<link rel='stylesheet' type='text/css' href='mainStyle.css' />";
			echo "<script src='mainScripts.js'></script>";
		?>
	</head>
	<body>
		<div id="stream">
			<?php
				// Let the user know that even though they
				// might not immeadiately see resukts,
				// we are processing results.
				echo 'Loading stream for ' . $_POST['sText'] . '...';
				ob_flush();
				flush();

				// Get all required packages.
				require __DIR__. '../../vendor/autoload.php';
				// Get variables we need in all pages.
				include __DIR__. '../Shared.php';

				// Use classes for the Twitter Streaming Api
				// and Yahoo Finance Api. Guzzle is used in
				// the Yahoo Finance Api
				use Spatie\TwitterStreamingApi\PublicStream;

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
			<span></span>
		</div>
	</body>
</html>
