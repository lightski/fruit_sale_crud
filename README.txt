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
	-secure input to delete?
	-offer to undelete on the fruit_report

[FUTURE ADD-ONS]
	-running total, in $$ and # items, on order entry page
	-fix report appearance in Chrome column headers
	-Proper data validation in process.php - only characters in fname/lname and only numbers in fruit
	-Proper data validation in index.php - $_GET["id"] is pretty insecure currently
	-User switchable years, which creates new table in database
	 (and switches to that for inserts and queries) must show up in totals and student report
	-Success and failure messages for data entry and updates. make it more reactive to user.
	-Mobile styling???

	-rewrite as a meteor.js app???

	+Allow user to edit student's order via clickable links on students_report {Added 11/15/14 DL}
	+Tweak student report column headers for readability {Removed slant 11/22/14 DL}
	+delete functionality on students_report page {Added 11/28/15 DL}
