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
				echo 'Loading stream for ' . $_POST['sText'] . '...';
				ob_flush();
				flush();

				require __DIR__. '../../vendor/autoload.php';
				include __DIR__. '../PersistentVars.php';

				use Spatie\TwitterStreamingApi\PublicStream;
				use Scheb\YahooFinanceApi\ApiClient;
				use Scheb\YahooFinanceApi\ApiClientFactory;
				use GuzzleHttp\Client;

				$tweetStream = $stream;
				$companyList = $fortune5CompanyList;

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
						ob_flush();
						flush();
					}
				}

				function printToScreen($u, $t)	{
					$t = addslashes($t);
					$t = preg_replace( "/\r|\n/", "", $t);

					$s = ''; // Company Symbol
					$c = ''; // Percent Change in stock
					$n = ''; // Company Name

					$client = ApiClientFactory::createApiClient();

					foreach ($GLOBALS['companyList'] as $company)	{
						$shortCompanyName = trim(formatCompanyName($company['Name']));
						if ($company['Name'] == 'General Electric')	{
							$shortCompanyName = 'GE';
						}
						if ($company['Name'] == 'General Motors')	{
							$shortCompanyName = 'GM';
						}

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

				function streaming_callback(array $tweet) {
					$username = $tweet['user']['screen_name'];
					$text = $tweet['text'];

					printToScreen($username, $text);
				}

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
