<html>
	<head>
		<!-- include links to CSS and JS Files -->
		<script><?php include 'mainScripts.js'; ?></script>
		<style> <?php include 'mainStyle.css';  ?></style>
	</head>
	<body>
		<input type="submit" id="stopTrick" value="Stop" onclick="changeVal()"></input>

		<div>
			<form action="../Misc/HandleFollowActions.php" method="POST" id="stream">
				<span></span>
				<?php
					// Get variables we need in all pages.
					require __DIR__. '../../Misc/Shared.php';

					// For whatever reason, sometimes we get duplicate results
					// stored and retrieved from the DB. This array helps prevent
					// duplication of results.
					$alreadyPrinted = array();

					//echo $_POST['user'];
					//ob_flush();
					//flush();
					// Persistant Variables from
					// "../Shared.php"
					$initTweets = $tweetFeedFirstTweets;
					$companyList = $fortune5CompanyList;
					$tweetStream = $stream;

					// Go through a list of tweets from the DB.
					// In that list, pull the "Username" and "Text"
					// of the tweet. If they have not been added to
					// a list of tweets we have previously added
					// then print them and add them to the list
					// of previously added tweets.
					function getInitialTweets()	{
						for ($i = 0; $i < count($GLOBALS['initTweets']); $i++)	{
							$tweet = $GLOBALS['initTweets'][count($GLOBALS['initTweets']) - ($i + 1)];
							$u = $tweet['Screen_Name'];
							$t = $tweet['Text'];

							if (!(in_array($u . '' . $t, $GLOBALS['alreadyPrinted'])))	{
								array_push($GLOBALS['alreadyPrinted'], $tweet['Screen_Name'] . '' . $tweet['Text']);
								printToScreen($u, $t);
							}
						}
					}

					// When the stream returns a result
					// this function is called. We want to
					// extract the "Username" and "Text" from
					// the tweet. Then we want to print that
					// information. We also wanr to add the tweet
					// to our DB if the "Username" is in our list of
					// people to follow.
					function streaming_callback(array $tweet) {
						$username = $tweet['user']['screen_name'];
						$text = $tweet['text'];

						printToScreen($username, $text);

						//Insert tweet into database
						if (in_array($username, $GLOBALS['FollowedNames']))	{
							$GLOBALS['tweetFeed']->insertOne([
								"Screen_Name" => $username,
								"Screen_Id" => $tweet['user']['id'],
								"Text" => $text,
								"Time" => date("Y-m-d H:i:s")
							]);
						}
					}

					// This starts the initial stream. We want
					// to get results from people who we follow,
					// or people who @ or RT them.
					function startStream()	{
						$users = $GLOBALS['FollowedIDs'];
						$GLOBALS['tweetStream']->whenTweets(
							$users,
							'streaming_callback'
						)->startListening();
					}

					getInitialTweets();
					startStream();
				?>
			</form>
		</div>
	</body>
</html>