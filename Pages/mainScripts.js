function LoadSetup()	{
	document.getElementById('streamFrame').submit();
	document.getElementById('searchOutput').style.display = 'none';
}

function searchVisibility()	{
	document.getElementById('searchOutput').style.display = 'block';
	document.getElementById('streamOutput').style.display = 'none';
}

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