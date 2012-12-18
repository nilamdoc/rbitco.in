li3_show
========

Shows all MongoDB queries at runtime for each page when it is loaded in your application.

Installation
====
The installation process is simple, just place the source code in the libraries-directory and create a li3_show directory:

$ cd /path/to/app/libraries
$ git clone git@github.com:nilamdoc/li3_show.git

Li3_show is a plugin, you can install it in your application as

    Libraries::add('li3_show');
    
It will show the following columns:

Collection     
Fields 	
Conditions 	
Order 	
Records 	
Limit		
Skip		
Batchsize		
Flags		
T-millis

It is tested with MongoDB only.

Please fork it and let us improved on this utility.