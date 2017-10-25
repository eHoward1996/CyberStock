<?php
	use Spatie\TwitterStreamingApi\PublicStream;

	// ----------------------------------------
	// MongoDB
		$m =  new MongoDB\Client;
		$db = $m->Tweetdemo;
	// ----------------------------------------
		$tweetFeed = $db->selectCollection('tweetfeed');
		$tweetFeedFirstTweets = iterator_to_array($tweetFeed->find(
			[],
			[
				'limit'     => 1000,
				'maxTimeMS' => 1500
			]
		));
	// -----------------------------------------
	$companies = $db->selectCollection('companies');
	$fortune5CompanyList = iterator_to_array($companies->find());
	// -----------------------------------------


	// Twitter Stream
	$consumerKey    	= '2iwAwSG6tzD12EtWSI7QUc8H2';
	$consumerSecret 	= 'Y6KeSGp2LzEeM8FecE4YcKnpoI2ie1n2v8mftH46uz4h4c7ig4';
	$accessToken        = '828704970593673217-fpjQo9kpuJ7dLSMtmmbPnPxRmo1OCEo';
	$accessTokenSecret  = 'SHHc9AvOBWVPGJdzyZQ5G5zOcHa6YR7wKoqyE2Lqjby5x';
	$stream = new PublicStream(
		$accessToken,
		$accessTokenSecret,
		$consumerKey,
		$consumerSecret
	);
?>