[README]
fruit sale CRUD app
this is the OFFICIAL fruit sale order counting app for the OSD
if any other app comes along please ignore it; there can only be one.

written in PHP with love, this app is designed to aid the counting of fruit sale orders

author: dan leitzke 06/30/2014

[INSTALLATION]
	-have web server with PHP and mySQL
	-copy directory to webroot on server OR clone via git
	-create a database and table in mySQL per the data_design.txt specifications
		-copy/pasteable instructions for mySQL should be provided in that document
	-open db_config.php.template with a text editor
		-change second set of values to match your server
		-save as db_config.php
	-OPTIONAL alter web server config to require a passsword for viewing this directory
	-open index.php and start entering orders

[@TODO]
	-deploy to server, protect with username/password
	-???
	-PROTIF!

[FUTURE ADD-ONS]
	-Tweak student report column headers for readability
	-Proper data validation in process.php - only characters in fname/lname and only numbers in fruit
	-User switchable years, which creates new table in database
	 (and switches to that for inserts and queries) must show up in totals.php as well
	-Success message and failure message for data entry
	-Box on index page for student lookup via fname or lname; allow user to edit student's order

