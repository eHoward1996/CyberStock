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
				// Get all required packages.
				require __DIR__. '../../vendor/autoload.php';
				// Get variables we need in all pages.
				include __DIR__. '../PersistentVars.php';

				// Use classes for the Twitter Streaming Api
				// and Yahoo Finance Api. Guzzle is used in
				// the Yahoo Finance Api
				use Spatie\TwitterStreamingApi\PublicStream;
				use Scheb\YahooFinanceApi\ApiClient;
				use Scheb\YahooFinanceApi\ApiClientFactory;
				use GuzzleHttp\Client;

				//@washingtonpost, 2467791
				//@business, 34713362
				//@YahooFinance, 19546277
				$UsersToFollow = array('follow' => [
					'2467791',
					'34713362',
					'19546277'
				]);
				// For whatever reason, sometimes we get duplicate results
				// stored and retrieved from the DB. This array helps prevent
				// duplication of results.
				$alreadyPrinted = array();

				// Persistant Variables from
				// "../PersistentVars.php"
				$initTweets = $tweetFeedFirstTweets;
				$companyList = $fortune5CompanyList;
				$tweetStream = $stream;

				// When we look through "../../Misc/Fortune500Companies.csv"
				// many of the companies in the file have extended company
				// names like Apple Inc, or Alphabet Inc, or Accenture plc.
				// Also if the name of the company has any special characters
				// such as "," or ".com" or "." or quotes, remove them.
				function formatCompanyName($longCompanyName)	{
					$shortCompanyName = '';

					foreach (explode(' ', $longCompanyName) as $str)	{
						if (!($str == 'Company' || $str == 'Co.' || $str == 'plc' ||
							  $str == 'Inc' || $str == 'Corp' || $str == 'Corporation' ||
							  $str == 'Group' || $str == 'Technologies' || $str == 'Pharmaceuticals' ||
							  $str == 'Class' || $str == 'Co' || $str == 'Group,' ||
							  $str == 'A' || $str == 'Corp.' || $str == 'Systems' || $str == 'Inc.' ||
							  $str == 'B'))	{

							if (strpos($str, ',') !== false)	{
								$str = str_replace(',', '', $str);
							}
							if (strpos($str, '.com') !== false)	{
								$str = str_replace('.com', '', $str);
							}
							if (strpos($str, '.') !== false)	{
								$str = str_replace('.', '', $str);
							}
							if (strpos($str, '"') !== false)	{
								$str = str_replace('"', '', $str);
							}
							$shortCompanyName .= $str . " ";
						}
					}
					return $shortCompanyName;
				}

				// This function writes a JavaScript call
				// to AddTweetsAtTop() to the page. This
				// Javascript function is located in
				// "../mainScripts.js". Everytime this
				// function is written to the screen
				// flush so we can see results immeadiately.
				function writeScript($u, $t, $n, $s, $c)	{
					if ($u != '' && $t != '')	{
						$script = 	"<script>
										AddTweetsAtTop(\"" .
											$u . "\", \"" .
											$t . "\", \"" .
											$n . "\", \"" .
											$s . "\", \"" .
											$c . "\"" .
										");
									</script>\n";
						echo $script;
						ob_flush();
						flush();
					}
				}

				// This function takes the "Username" and
				// "Text" associated with a tweet and writes
				// it to the screen. It adds slashes to tweets
				// if they contain a quote. Also, if the tweet
				// contains a company in the Fortune500, add
				// the company name, the company symbol, and
				// the percent change in stock value to the
				// information we want to write to the screen.
				function printToScreen($u, $t)	{
					$t = addslashes($t);
					$t = preg_replace( "/\r|\n/", "", $t);

					$s = ''; // Company Symbol
					$c = ''; // Percent Change in stock
					$n = ''; // Company Name

					$client = ApiClientFactory::createApiClient();

					foreach ($GLOBALS['companyList'] as $company)	{
						$shortCompanyName = trim(formatCompanyName($company['Name']));

						if ($company['Name'] == 'Alphabet')	{
							$shortCompanyName = 'Google';
						}
						if ($company['Name'] == 'General Electric')	{
							$shortCompanyName = 'GE';
						}
						if ($company['Name'] == 'General Motors')	{
							$shortCompanyName = 'GM';
						}

						if (strpos(strtoupper($t), strtoupper($shortCompanyName) . " ") !== false)	{
							$s = $company['Symbol'];
							$q = $client->getQuote($s);
							$c = $q->getPercentChange();
							$n = $q->getName();
							break;
						}
					}
					writeScript($u, $t, $n, $s, $c);
				}

				// Go through a list of tweets from the DB.
				// In that list, pull the "Username" and "Text"
				// of the tweet. If they have not been added to
				// a list of tweets we have previously added
				// then print them and add them to the list
				// of previously added tweets.
				function getInitialTweets()	{
					foreach ($GLOBALS['initTweets'] as $tweet) {
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
					$users = $GLOBALS['UsersToFollow']['follow'];
					$username = $tweet['user']['screen_name'];
					$text = $tweet['text'];

					printToScreen($username, $text);

					//Insert tweet into database
					if (in_array($tweet['user']['id'], $users))	{
						$doc = $GLOBALS['tweetFeed']->insertOne([
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
					$users = $GLOBALS['UsersToFollow']['follow'];
					$GLOBALS['tweetStream']->whenTweets(
						$users,
						'streaming_callback'
					)->startListening();
				}

				getInitialTweets();
				startStream();

			?>
			<span></span>
		</div>
	</body>
</html>