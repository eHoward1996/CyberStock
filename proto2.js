var mongoose = require('mongoose');   

var express = require('express'); 
var app = express();

var fs = require('fs');
var path = require('path');

var uri = 'mongodb://abcd1234:abcd1234@ds163738.mlab.com:63738/humongotestdb';

mongoose.Promise = global.Promise

mongoose.connect(uri);

var db = mongoose.connection;

db.on('error', console.error.bind(console, 'connection error:'));

db.once('open', function callback () {

	var list = [];

	// Create song schema
  	var songSchema = mongoose.Schema({
    			symbol: String,
    			name: String,
    			text: String,
  	});

  	var Song5 = mongoose.model('songs4', songSchema);

	Song5.find({symbol: 'none'}, function(err, purple){
			
		if (err) throw err;

		var texts = purple.map(function(text) {
    			return text['text'];
    		});

		var names = purple.map(function(name) {
    			return name['name'];
    		});

		var symbols = purple.map(function(symbol) {
    			return symbol['symbol'];
    		});
			
		for (i=0; i<symbols.length; i++){
			var tempText = symbols[i].toUpperCase();
			var inputText = 'none';
			var inputText2 = inputText.toUpperCase();
			if(tempText.includes(inputText2)){
				if(fs.existsSync("dbTxt.csv")){
					fs.appendFile("dbTxt.csv", names[i] + "," + texts[i] + "\n", function(err){
						if(err) {
							return console.log(err);
						}
					});
				}
				else{
					fs.writeFile("dbTxt.csv", "Name" + "," + "Text" + "\n", function(err){
						if(err) {
							return console.log(err);
						}
					});
				}
				//console.log(names[i] + "      " + texts[i]);
			}
				
		}

		
		//console.log(texts); //prints out text clooection / array element

		mongoose.connection.db.close(function (err) {
            				if(err) throw err;
          	});


	});
});