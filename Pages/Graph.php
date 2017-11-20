<html>
	<head>
		<!-- include links to CSS and JS Files -->
		<script><?php include 'mainScripts.js'; ?></script>
		<style> <?php include 'mainStyle.css';  ?></style>

		<!-- <script type="text/javascript" src="https://www.google.com/jsapi"></script>
		<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script> -->
		<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
		<?php
			require __DIR__. '../../Misc/Shared.php';

			$tf = $tweetFeed;
			$followTweets = iterator_to_array($tf->find(
				[
					'Screen_Name' => substr($_POST['gText'], 1)
				]
			));

			$alreadyPrinted = array();
			$tweetsPerDay = array();

			foreach ($followTweets as $t)	{
				$timeToArr = preg_split("/[\s]/", $t['Time']);
				$date = $timeToArr[0] . "";

				if (!(in_array($date . '' . $t['Text'], $GLOBALS['alreadyPrinted'])))	{
					array_push($GLOBALS['alreadyPrinted'], $date . '' . $t['Text']);

					if (!isset($tweetsPerDay[$date]))	{
						$tweetsPerDay[$date] = 0;
					}
					$tweetsPerDay[$date] += 1;
				}
			}

			$tweetsPerDayAsStrArr = '';
			foreach ($tweetsPerDay as $day => $tweets)	{
				$tweetsPerDayAsStrArr .= '["' . $day . '", ' . $tweets . '],';
			}
			$tweetsPerDayAsStrArr = rtrim($tweetsPerDayAsStrArr, ',');

			$script =
			'<script>
				google.charts.load("current", {"packages":["corechart", "bar"]});
				google.charts.setOnLoadCallback(drawChart);

				function drawChart() {
					var data = google.visualization.arrayToDataTable([
						["Date", "Tweets"],' . $tweetsPerDayAsStrArr . '
					]);

					var options = {
						title: "Tweets Per Day for ' . $_POST['gText'] . '",
						legend: { position: "bottom" },
						width: "100%",
						height: "100%"
					};

					var chart = new google.charts.Bar(document.getElementById("chart_div"));
					chart.draw(data, options);
				}
			</script>';
			echo $script;
		?>
	</head>

	<body>
		<center>
			<div id="chart_div">

			</div>
		</center>
	</body>
</html>