Directions for running express / webpage.

1. Install node.js 
	- Go to this site (https://nodejs.org/en/download/package-manager/#windows), find your OS, follow the steps.

2. Download / unpack the zip.

3. Navigate to this folder in command prompt terminal.

4. Type "node exprss.js" to start the express local web server
**exprss.js will not return anything and needs to coninuously run

5. Open a new terminal and navigate to the same folder.
** Do not close the exprss.js terminal.

6. Open another terminal window.

7. Type "node proto1.js" to start the API stream function which continuously adds new tweets to the database
** recommended that a dbTxt.csv file currently exists and that it is not open while the program is running

8. Type "node proto2.js" to create a new csv file containing database values.
** recommended that a dbTxt.csv file does not currently exist

9. Open a browser and type "http://localhost:3000/index.html" into the address bar.


Accessing the database:

1. Go to "https://mlab.com/home"

2. Use the following login information: "User: apple1234   Passowrd: !QAZ2wsx" to log in

3. Click "ds163738/humonotestdb"

** song4 is the collection we are using for submission. The other two are being utilized for testing.


Updating the Followers list:

**Do not add and/or delete multiple names in followers2 at one time without running proto3.js. If the two csv files are equal in length but do 
  not contain the same names, the script will not function correctly.
**Verify that any screenname that you add to followers2 is a valid screenname prior to running the script.

1. To add, type the screen name of the person you wish at the bottom of followers2.csv file, 
save the file, and run proto3.js by navigating to the file where the scrip resides 
and type "node proto3.js". Do not modify followers.csv.

2. To delete, simply delete the cell of the desired names from followers2.csv, save the file, 
and run proto3.js by navigating to the file where the scrip resides and type "node proto3.js". 
Do not modify followers.csv.




