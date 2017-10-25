<html>
	<head>
		<?php
			echo "<link rel='stylesheet' type='text/css' href='mainStyle.css' />";
			echo "<script src='mainScripts.js'></script>";
		?>
	</head>
	<body>
		<div id="stream">
			<?php
				require __DIR__. '../../vendor/autoload.php';

				use Spatie\TwitterStreamingApi\PublicStream;
				use Scheb\YahooFinanceApi\ApiClient;
				use Scheb\YahooFinanceApi\ApiClientFactory;
				use GuzzleHttp\Client;

				// Global vars
				//@washingtonpost, 2467791
				//@business, 34713362
				//@YahooFinance, 19546277
				$UsersToFollow = array('follow' => [
					'2467791',
					'34713362',
					'19546277'
				]);
				$alreadyPrinted = array();

				//Connect to MongoDB client, select the db and collection
				session_start();
				$m =  new MongoDB\Client;
				$_SESSION['db'] = $m->Tweetdemo;

				$tweetFeed = $_SESSION['db']->selectCollection('tweetfeed');
				$companyList = iterator_to_array($_SESSION['db']->selectCollection('companies')->find());

				function formatCompanyName($longCompanyName)	{
					$shortCompanyName = '';

					foreach (explode(' ', $longCompanyName) as $str)	{
						if ($str == 'Alphabet')	{
							$shortCompanyName = 'Google';
						}
						else if (!($str == 'Company' || $str == 'Co.' || $str == 'plc' ||
								   $str == 'Inc' || $str == 'Corp' || $str == 'Corporation' ||
								   $str == 'Group' || $str == 'Technologies' || $str == 'Pharmaceuticals' ||
								   $str == 'Class' || $str == 'Co' || $str == 'Group,' ||
								   $str == 'A' || $str == 'Corp.' || $str == 'Systems' || $str == 'Inc.'))	{

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
					}
				}

				function printToScreen($u, $t)	{
					$t = addslashes($t);
					$t = preg_replace( "/\r|\n/", "", $t);

					$client = ApiClientFactory::createApiClient();

					foreach ($GLOBALS['companyList'] as $company)	{
						$shortCompanyName = trim(formatCompanyName($company['Name']));
						if ($company['Name'] == 'General Electric')	{
							$shortCompanyName = 'GE';
						}
						if ($company['Name'] == 'General Motors')	{
							$shortCompanyName = 'GM';
						}

						$s = '';
						$c = '';
						$n = '';
						if (strpos($t, $shortCompanyName) !== false)	{
							$s = $company['Symbol'];
							$q = $client->getQuote($s);
							$c = $q->getPercentChange();
							$n = $q->getName();
							break;
						}
					}
					writeScript($u, $t, $n, $s, $c);
				}

				function getInitialTweets()	{
					$firstTweets = iterator_to_array($GLOBALS['tweetFeed']->find([],[
						'limit'     => 100,
						'maxTimeMS' => 1000
					]));

					foreach ($firstTweets as $tweet) {
						$u = $tweet['Screen_Name'];
						$t = $tweet['Text'];

						if (!(in_array($u . '' . $t, $GLOBALS['alreadyPrinted'])))	{
							array_push($GLOBALS['alreadyPrinted'], $tweet['Screen_Name'] . '' . $tweet['Text']);
							printToScreen($u, $t);
						}
					}
				}

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

				function startStream()	{
					$users = $GLOBALS['UsersToFollow']['follow'];

					$consumerKey    	= '2iwAwSG6tzD12EtWSI7QUc8H2';
					$consumerSecret 	= 'Y6KeSGp2LzEeM8FecE4YcKnpoI2ie1n2v8mftH46uz4h4c7ig4';
					$accessToken        = '828704970593673217-fpjQo9kpuJ7dLSMtmmbPnPxRmo1OCEo';
					$accessTokenSecret  = 'SHHc9AvOBWVPGJdzyZQ5G5zOcHa6YR7wKoqyE2Lqjby5x';

					PublicStream::create(
					    $accessToken,
					    $accessTokenSecret,
					    $consumerKey,
					    $consumerSecret
					)->whenTweets(
						$users,
						'streaming_callback'
					)->startListening();
				}

				getInitialTweets();

				ob_flush();
			   	flush();

    			// Start tweet stream
				startStream();
			?>
			<span></span>
		</div>
	</body>
</html>