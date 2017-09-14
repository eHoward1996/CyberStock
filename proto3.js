var Twitter = require('twitter');

var express = require('express'); 
var app = express();

var mongoose = require('mongoose');   

var fs = require('fs');
var path = require('path');

var parse

var client = new Twitter({
  consumer_key: 'FfDJtfN7GAsqbQG2FfGRdVZ2U',
  consumer_secret: '42QOdbfWYDUgwQF88n1crS3ddaJI0tJ1KS57sZrUN8u5U4u8Fy',
  access_token_key: '821107691804303361-MKzqAA6H7YNKl5CzUanc6eT9Vh5zzmk',
  access_token_secret: '4LOaGKFs3CN143rrSYkXbdK1hat2lp3Cg1cPjtDk76Oge'
});

var params = {screen_name: 'realDonaldtrump'};

<!-- client.post('friendships/create', params, function(){}); -->

var fs = require('fs'); 
var parse = require('csv-parse');

var csvData=[];
var count = 0;
fs.createReadStream('followers.csv')
    .pipe(parse({delimiter: ','}))
    .on('data', function(csvrow) {
        //console.log(csvrow);
        //do something with csvrow
        csvData.push(csvrow);  
	count++;      
    })
    .on('end',function() {
      //do something wiht csvData
      //console.log(csvData);
	var csvData2=[];
	var count2 = 0;
	fs.createReadStream('followers2.csv')
    	.pipe(parse({delimiter: ','}))
    	.on('data', function(csvrow) {
        	//console.log(csvrow);
        	//do something with csvrow
        	csvData2[count2] = csvrow; 
		count2 += 1;    
		//console.log(csvData2[1]);   
    	})
    	.on('end',function() {
      	//do something wiht csvData
      	//console.log(csvData2);
	if(csvData.length > csvData2.length){
		//console.log(csvData);
		var bigStr = "";
		for(var v = 0; v < csvData2.length; v++){
			bigStr = bigStr + csvData2[v][0] + "\n";
		}
		for( var w = 0; w < csvData.length; w++){
			if(bigStr.includes(csvData[w][0]))
				console.log("");
			else{
				//console.log(csvData[w][0]);
				var params5 = {screen_name: csvData[w][0]};
				client.post('friendships/destroy', params5, function(){}); 
				var tempVal = csvData[w][0];
				fs.truncate("followers.csv", 0, function() {
					for(var pp = 0; pp < csvData.length; pp++){
						if(csvData[pp][0] !== tempVal){
							var tempstr = csvData[pp][0] + "\n";
    							fs.appendFile("followers.csv", tempstr, function (err) {
        							if (err) {
            								return console.log("Error writing file: " + err);
        							}
    							});
						}
					}
				});
			}
		}
	}
	else if(csvData.length < csvData2.length){
		//console.log(csvData);
		var bigStr = "";
		for(var v = 0; v < csvData.length; v++){
			bigStr = bigStr + csvData[v][0] + "\n";
		}
		for( var w = 0; w < csvData2.length; w++){
			if(bigStr.includes(csvData2[w][0]))
				console.log("");
			else{
				//console.log(csvData[w][0]);
				var params5 = {screen_name: csvData2[w][0]};
				client.post('friendships/create', params5, function(){}); 
				fs.appendFile("followers.csv", csvData2[w][0] + "\n", function(err){
					if(err) {
						return console.log(err);
					}
				});
			}
		}
	}
	else{
		console.log('');
	}
    	});	
    });







