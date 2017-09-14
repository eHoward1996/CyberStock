var Twitter = require('twitter');

var express = require('express'); 
var app = express();

var mongoose = require('mongoose');   

var fs = require('fs');
var path = require('path');

var client = new Twitter({
  consumer_key: 'FfDJtfN7GAsqbQG2FfGRdVZ2U',
  consumer_secret: '42QOdbfWYDUgwQF88n1crS3ddaJI0tJ1KS57sZrUN8u5U4u8Fy',
  access_token_key: '821107691804303361-MKzqAA6H7YNKl5CzUanc6eT9Vh5zzmk',
  access_token_secret: '4LOaGKFs3CN143rrSYkXbdK1hat2lp3Cg1cPjtDk76Oge'
});

var params = {screen_name: 'letmemakeanacc', count: 200};
		// Create song schema
  		var songSchema = mongoose.Schema({
    				symbol: String,
    				name: String,
    				text: String,
  		});

  		// Store song documents in a collection called "songs"
  		var Song4 = mongoose.model('songs4', songSchema);

client.stream('user', {with: 'followings'},  function(stream) {
	stream.on('data', function(tweet) {
		app.route('/').get(function(req, res){
			res.send(tweet.text);
  		});

  	<!-- console.log(tweets[0]); -->
  	var texts = tweet.text;

  	var names = tweet['user']['screen_name'];

  	var conc = names + "          " + texts; <!-- prints entire arrays (2) -->
  	console.log(conc);
 

	var uri = 'mongodb://abcd1234:abcd1234@ds163738.mlab.com:63738/humongotestdb';

	mongoose.Promise = global.Promise

	mongoose.connect(uri);

	var db = mongoose.connection;

	db.on('error', console.error.bind(console, 'connection error:'));

	db.once('open', function callback () {

		var list = [];

  		var nineties = new Song4({
    			symbol: 'none',
    			name: names,
    			text: texts,
  		});

		if(fs.existsSync("dbTxt.csv")){
			fs.appendFile("dbTxt.csv", names + "," + texts + ",", function(err){
				if(err) {
					return console.log(err);
				}
			});
		}
		else{
			fs.writeFile("dbTxt.csv", "Name" + "," + "Text" + ",", function(err){
				if(err) {
					return console.log(err);
				}
			});
		}

		list[0] = [nineties];
		Song4.insertMany(list[0]);
	
		console.log(list);

		Song4.update( 
    			function (err, numberAffected, raw) {

      				if (err) return handleError(err);

      				Song4.find({ weeksAtOne: { $gte: 10} }).sort({ decade: 1}).exec(function (err, docs){

        				if(err) throw err;
					
					<!-- uncomment to drop table -->
					<!-- mongoose.connection.db.collection('songs4').drop(function (err) { -->
          					<!-- if(err) throw err; -->
					<!-- }); -->

          				mongoose.connection.db.close(function (err) {
            					if(err) throw err;
          				});
				});
			}
	 	)
         });

      console.log("i work.");
   });

});
