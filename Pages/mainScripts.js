// This function is called in TwitterFingerz.php to
// initialize the stream and make the search stream
// not visible.
function LoadSetup()	{
	document.getElementById('streamFrame').submit();
}

// This function allows all the tweets to
// be added at the top of the stream as
// opposed to the bottom. Also adds hyperlinks
// if the text contains "https://". Adds
// stock symbols and stock percent change if
// the tweet contains the name of a fortune 500
// company. If the text contains the name of a
// fortune 500 company the percent change
// will be colored red or green based on whether
// there was an increase or decrease in sales.
// Formats tweet seperation with a line break (<br>)
// and a horizontal rule (<hr>)
function AddTweetsAtTop(username, text, stockName, stockSymbol, stockChange)	{
	var pTweet = document.createElement("p");
	pTweet.className = "tweet";

	var link = text.lastIndexOf('https://');
	var a = document.createElement("a");

	if (link > -1) {
		link = text.substring(text.lastIndexOf('https://'));
		text = text.substring(0, text.indexOf('https://'));

		a.appendChild(document.createTextNode(link));
	 	a.setAttribute("href", link);
	 	a.setAttribute("text", link);
	 	a.setAttribute("target", "_blank");
	}

	var tweet = document.createTextNode(username + " : " + text);
	var stock = document.createElement("span");

	if (stockName != '' && stockSymbol != '' && stockChange != '')	{
		stock.appendChild(document.createTextNode("  ||  " + stockName + "  (" + stockSymbol + ")  " + stockChange + "%  ||"));
		stock.setAttribute('style', 'color: green;');

		if (parseFloat(stockChange) < 0)	{
			stock.setAttribute('style', 'color: red;');
		}
	}

	pTweet.appendChild(tweet);
	pTweet.appendChild(a);
	pTweet.appendChild(stock);
	pTweet.appendChild(document.createElement("br"));
	pTweet.appendChild(document.createElement("hr"));

	var stream = document.getElementById("stream");
	stream.insertBefore(pTweet, stream.childNodes[0]);
}