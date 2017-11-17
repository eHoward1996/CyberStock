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
				include __DIR__. '../PersistentVars.php';

				// Use classes for the Twitter Streaming Api
				// and Yahoo Finance Api. Guzzle is used in
				// the Yahoo Finance Api
				use Spatie\TwitterStreamingApi\PublicStream;
				use Scheb\YahooFinanceApi\ApiClient;
				use Scheb\YahooFinanceApi\ApiClientFactory;
				use GuzzleHttp\Client;

				// Persistant Variables from
				// "../PersistentVars.php"
				$tweetStream = $stream;
				$companyList = $fortune5CompanyList;


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
					$t = preg_replace("/\r|\n/", "", $t);
					$t = preg_replace("/&amp;+/", "&", $t);

					$s = ''; // Company Symbol
					$c = ''; // Percent Change in stock
					$n = ''; // Company Name

					$client = ApiClientFactory::createApiClient();

					foreach ($GLOBALS['companyList'] as $company)	{
						$cNameInText = true; // Check if the company name is in the tweet
						$shortCompanyName = formatCompanyName($company['Name']);

						if ($shortCompanyName == 'Alphabet')	{
							$shortCompanyName = 'Google';
						}
						else if ($shortCompanyName == 'General Electric')	{
							$shortCompanyName = 'GE';
						}
						else if ($shortCompanyName == 'General Motors')	{
							$shortCompanyName = 'GM';
						}
						else if ($shortCompanyName == 'Chipotle Mexican Grill')	{
							$shortCompanyName = 'Chipotle';
						}
						$nameToArr = preg_split("/[\s,]+/", strtoupper($shortCompanyName));

						$textToArr = $t;
						$textToArr = preg_replace("/'s/", '', $textToArr);
						$textToArr = preg_replace("#[[:punct:]]#", "", $textToArr);
						$textToArr = preg_split("/[\s,]+/", strtoupper($textToArr));
						foreach ($nameToArr as $name)	{
							if (!in_array($name, $textToArr))	{
								$cNameInText = false;
								break;
							}
						}

						if ($cNameInText)	{
							$s = $company['Symbol'];
							$q = $client->getQuote($s);
							$c = round($q->getRegularMarketChangePercent(), 3);
							$n = $q->getShortName();
							break;
						}
					}
					writeScript($u, $t, $n, $s, $c);
				}

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
