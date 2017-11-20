# Iteration 4
+ Added **Stop** function to stream service
  + User has the option to **Stop/Start** stream service
+ Renamed several files
  + _Pages/CyberStock.php_ to _Pages/Home.php_
  + _Pages/PersistentVars.php_ to _Pages/Shared.php_
  + _Pages/StreamAcess.php_ to _Pages/Stream.php_
+ Added Statistical Analysis functionality (Graph.php)
  + The Graph shows tweets per day of a selected user in the FollowedName list.

# Iteration 3
+ Deleted erroneous and unused code
+ Deleted unused files
+ Updated folder structure
+ Replaced tmhOAuth Twitter Streaming API with Spatie Twitter Streaming API
  + Faster with returning results
  + Ease of use
  + Modularized commonly used variables (Pages/PersistentVars.php)
+ Added search functionality (Pages/Search.php)
  + Works with Usernames and general terms
+ Added functionality for stock symbols and percent change
+ Added Stock Symbol, Company Name, and Percent Change to a tweet if the text of the tweet has the name of a Fortune 500 company in it
+ Added hyperlinks to tweet text
+ Added a manual to address FAQs
+ Added comments

# Iteration 2
+ Moved Project to GitHub
+ Begin making improvements to "TwitterFingerz" project