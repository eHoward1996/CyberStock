<?php
	use Spatie\TwitterStreamingApi\PublicStream;

	// MongoDB client
	$m =  new MongoDB\Client;

	// The actual DB "Tweetdemo"
	$db = $m->Tweetdemo;

	// Get reference to the tweetfeed collection.
	// Create a list of the first 1000 records. Set
	// a max response time (maxTimeMS) of 1.5 seconds.
	$tweetFeed = $db->selectCollection('tweetfeed');
	$tweetFeedFirstTweets = iterator_to_array($tweetFeed->find(
		[],
		[
			'limit'     => 1000,
			'maxTimeMS' => 1500
		]
	));

	// Get reference to the companies collection.
	// Create a list of all companies in the collection.
	$companies = $db->selectCollection('companies');
	$fortune5CompanyList = iterator_to_array($companies->find());

	// Twitter Stream variables
	$consumerKey    	= '2iwAwSG6tzD12EtWSI7QUc8H2';
	$consumerSecret 	= 'Y6KeSGp2LzEeM8FecE4YcKnpoI2ie1n2v8mftH46uz4h4c7ig4';
	$accessToken        = '828704970593673217-fpjQo9kpuJ7dLSMtmmbPnPxRmo1OCEo';
	$accessTokenSecret  = 'SHHc9AvOBWVPGJdzyZQ5G5zOcHa6YR7wKoqyE2Lqjby5x';

	// Create an instance of the Stream class
	// using the above variables
	$stream = new PublicStream(
		$accessToken,
		$accessTokenSecret,
		$consumerKey,
		$consumerSecret
	);

	// Classes for Yahoo Finance API.
	// Guzzle is neceessary to use the YFA
	use Scheb\YahooFinanceApi\ApiClient;
	use Scheb\YahooFinanceApi\ApiClientFactory;
	use GuzzleHttp\Client;

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
				  $str == 'B' || $str == 'C' || $str == "Svc.Gp"))	{

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
				if (strpos($str, '\'s') !== false)	{
					$str = str_replace('\'s', '', $str);
				}
				$shortCompanyName .= ' ' . $str;
			}
		}
		return trim($shortCompanyName);
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
?>