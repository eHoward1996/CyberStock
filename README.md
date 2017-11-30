# CyberStock - A Social Media Analysis Tool

> The objective for this application is to display financial and stock related
 information that is received from Twitter.  The web application will display a
 constant stream of tweets related to Fortune 500 companies and display the stock
 information of each company respectively.  All of the incoming tweets will be
 stored in a database.  Our application will also analyze the tweets and provide
 the user with statistics regarding the tweets or the information within the tweets.
 The purpose of this project is to ensure our audiences are aware of current events
 in the financial and stock market world in real lifetime.  This will allow users to
 make sound investment decisions effortlessly and swiftly.


## Software Requirements:
+    Xampp with PHP 7.1
+    MongoDB
+    MongoDB PHP Driver
+    Composer

## MongoDB Installation
1. Download and install the latest version of MongoDB Community Server
 [Currently 3.4.4](https://www.mongodb.com/download-center?jmp=nav#community)
2. Once installed create a new folder in the "C:\\" drive and name it "data".
 Within the "data" folder create another folder named "db".
3. Download the latest MongoDB-PHP driver. This PHP Driver must
 match the PHP version of your Xampp install. It is also dependent on the
 version of MongoDB that is installed on your machine. Since we are using
 MongoDB version 3.4 and PHP version 7.1 our MongoDB-PHP driver should be a
 minimum of version 1.2. We will be using version 1.2.8 found [here](http://pecl.php.net/package/mongodb).
 For a full compatibility list visit: [MongoDB Compatability List](https://docs.mongodb.com/ecosystem/drivers/php/#compatibility)
4. Click on the MongoDB-PHP driver that is compatible and navigate to 'DLL'
 list. There are 4 downloads for each version of PHP, categorized by your
 operating system's architecture and whether or not your version of PHP
 utilizes thread safety. To find this information go to your web browser and
 in the address bar type: "localhost/phpinfo.php".
 > If the file does not exist, navigate to "C:\path\to\xampp\htdocs" and create a file
 named "phpinfo.php". Inside of that file put the following code <pre><code><?php phpinfo(); ?></code></pre>
5. <kbd>Ctrl</kbd> + <kbd>F</kbd> search for "Thread Safety" to determine whether it is enabled or disabled on your machine.
 If it is enabled choose a MongoDB-PHP driver link that contains "(TS)" and if your installation
 of Windows is 32-bit make sure that it also contains "x86".
6. The downloaded zip file will contain a dll file "php_mongodb.dll" which should
 be placed within your Xampp install folder. Ex. "C:\xampp\php\ext"
7. Next add the extension to Xampp by going to "C:\xampp\php" and opening "php.ini",
 <kbd>Ctrl</kbd> + <kbd>F</kbd> to search for "extension=" and add this line within the
 extension section: "extension=php_mongodb.dll"
8. Modify the PATH variables for both MongoDB and the MongoDB-PHP driver.
 Go to control panel, and open system settings. Click on the 'Advanced' tab and then click on 'Environment
 Variables' at the bottom on the window. Find the System Variable "Path" and click edit.
 To add a new variable semicolon after each path and add the following paths:
> Xampp: Ex. "C:\xampp\php"
> MongoDB: Ex. "C:\Program Files\mongodb\Server\3.4\bin"
9. To verify successful installation restart the Apache server and in the address bar type: "localhost/phpinfo.php".
 <kbd>Ctrl</kbd> + <kbd>F</kbd> to search for "mongo" and there should be a new section that now shows your
 version of the MongoDB-PHP driver.


## Setting Up MongoDB
1. After MongoDB is installed open a command prompt window and type
 <pre><code>mongod</code></pre>
 Let the window load the server you will see "waiting for connection on port xxxxxx".
 **LEAVE THIS WINDOW OPEN WHILE RUNNING THE DATABASE.**
2. Open another command prompt window and type <pre><code>mongo</code></pre>
3. In the command prompt type <pre><code>use Tweetdemo</code></pre>
 This will create the database and switch to the
 Tweetdemo database.
4. In the command prompt type <pre><code>db.createCollection('tweetfeed')</code></pre>
 This will create the collection to database to hold the tweets.


## Composer Installation
1. Download and run the [Composer Windows installer](https://getcomposer.org/download/)
2. Once installed open the Windows command line.
3. Navigate to the working directory for Xampp using cd.
 Ex. <pre><code>cd	xampp\htdocs\</code></pre>
4. Type <pre><code>composer require mongodb/mongodb=^1.0.0 --ignore-platform-reqs</code></pre>
 Composer and all the necessary PHP libraries required for this application should now be installed in this folder.


## Web Application Installation
1. Unzip the src_tf folder.
2. Copy the src_tf (unzipped) folder to your XAMPP htdocs folder. Ex. "C:\xampp\htdocs"
3. Double-click the src_tf folder in your htdocs folder.
4. Double-click the "CyberStock" folder.
5. Ensure that there are 3 folders within the CyberStock folder. (Misc, Pages, and vendor)
6. Open the XAMPP control panel and ensure the Apache server is	running.
7. In your web browser's address bar, enter "localhost/" plus the
 path to your 'Pages/Home.php' file: <pre><code>http://localhost/src_tf/CyberStock/Pages/Home.php</code></pre>
8. The website should open to a heading with all of the team members names, and
 begin the stream of tweets

**Note: When you want to add another you must first get the userID
from gettwitterid.com. Then add to the "$FollowedID" variable in
"Misc/Shared.php" file Note: We realize that this project only needs to get
original tweets from users, and not mentions and retweets by other people. Our
stream will only display orignial tweets in future iterations.         We
included this example of the stream to show that we have made progress in being
able to connect to the Twitter Streaming API and gather data.**