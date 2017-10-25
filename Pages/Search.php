<html>
	<head>
		<?php
			echo "<link rel='stylesheet' type='text/css' href='mainStyle.css' />";
			echo "<script src='mainScripts.js'></script>";

			$companyList = iterator_to_array($_SESSION['db']->selectCollection('companies')->find());
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

				echo 'Loading stream for ' . $_POST['sText'] . '...';
				ob_flush();
				flush();

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

				function streaming_callback(array $tweet) {
					$username = $tweet['user']['screen_name'];
					$text = $tweet['text'];

					printToScreen($username, $text);
				}

				function startStream()	{
					$consumerKey    	= '2iwAwSG6tzD12EtWSI7QUc8H2';
					$consumerSecret 	= 'Y6KeSGp2LzEeM8FecE4YcKnpoI2ie1n2v8mftH46uz4h4c7ig4';
					$accessToken        = '828704970593673217-fpjQo9kpuJ7dLSMtmmbPnPxRmo1OCEo';
					$accessTokenSecret  = 'SHHc9AvOBWVPGJdzyZQ5G5zOcHa6YR7wKoqyE2Lqjby5x';

					PublicStream::create(
					    $accessToken,
					    $accessTokenSecret,
					    $consumerKey,
					    $consumerSecret
					)->whenHears(
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
