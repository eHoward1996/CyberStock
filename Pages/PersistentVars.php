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
?>