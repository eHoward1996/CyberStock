// This function is called in TwitterFingerz.php to
// initialize the stream and make the search stream
// not visible.
function LoadSetup()	{
	document.getElementById('streamFrame').submit();
}

var clicks = 0;
var clunks = 0;
var print = true;

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
function AddTweetsAtTop(username, text, stockName, stockSymbol, stockChange, inFollowList, userID)	{
	if (!print)	{
		return;
	}

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

	var followAction = document.createElement("button");
	followAction.innerHTML = "+";
	if (inFollowList)	{
		followAction.innerHTML = "-";
	}
	followAction.addEventListener("click", function() {
		performAction(username, userID, followAction.innerHTML == "+" ? "add" : "remove");
	});

	var tweet = document.createElement("span");
	tweet.appendChild(document.createTextNode(username + " : " + text));
	tweet.setAttribute('style', 'margin-left: 2em;');

	var stock = document.createElement("span");
	if (stockName != '' && stockSymbol != '' && stockChange != '')	{
		stock.appendChild(document.createTextNode("  ||  " + stockName + "  (" + stockSymbol + ")  " + stockChange + "%  ||"));
		stock.setAttribute('style', 'color: green;');

		if (parseFloat(stockChange) < 0)	{
			stock.setAttribute('style', 'color: red;');
		}
	}

	pTweet.appendChild(followAction);
	pTweet.appendChild(tweet);
	pTweet.appendChild(a);
	pTweet.appendChild(stock);
	pTweet.appendChild(document.createElement("br"));
	pTweet.appendChild(document.createElement("hr"));

	var stream = document.getElementById("stream");
	stream.insertBefore(pTweet, stream.childNodes[0]);
}

function changeVal()	{
	var stop = document.getElementById("stopTrick");
	clicks++;

	if (clicks % 2 == 1)	{
		stop.value = "Start";
		print = false;
	}
	else	{
		stop.value = "Stop";
		print = true;
	}
}

function stopSearch()	{
	var stopS = document.getElementById("stopZ");
	clunks++;

	if (clunks % 2 == 1)	{
		print = false;
	}
	else	{
		print = true;
	}
}

function performAction(username, userID, actionItem)	{
	if (confirm('Are you sure you want to ' + actionItem + ' user "' + username + '"?')) {
		var actionData = document.createElement("p");
		var user = document.createElement("input");
		var id = document.createElement("input");
		var action = document.createElement("input");

		actionData.setAttribute('id', 'actionData');
		user.setAttribute('name', 'user');
		id.setAttribute('name', 'id');
		action.setAttribute('name', 'action');

		user.setAttribute('value', username);
		id.setAttribute('value', userID);
		action.setAttribute('value', actionItem);

		actionData.appendChild(user);
		actionData.appendChild(id);
		actionData.appendChild(action);
		actionData.setAttribute('style', 'display: inline;');

		var stream = document.getElementById("stream");
		stream.insertBefore(actionData, stream.childNodes[0]);

		document.getElementById('stream').submit();
	}
}