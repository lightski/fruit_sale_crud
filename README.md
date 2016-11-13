# fruit sale CRUD app
This is the official fruit sale order counting app for OSD. 
Written to aid counting of fruit orders as part of a fundraiser.
See data_design.txt for table layout and data design.
I doubt this exact setup will help anyone, but it is an okay 
starting point if you're writing a PHP crud app. 
I've used the architecture in a few other projects as well;
it's nice to cross-pollinate and add back improvements as they
come to me.

## INSTALLATION
	- have web server with PHP and mySQL
	- copy directory to webroot on server OR clone via git
	- create a database and table in mySQL per the data_design.txt specifications
		- copy/pasteable instructions for mySQL should be provided in that document
	- open db_config.php.template with a text editor
		- change second set of values to match your server
		- save as db_config.php
	- OPTIONAL alter web server config to require a passsword for viewing this directory
	- open index.php and start entering orders

## CHANGING YEARS
As of 2015-11-28, to switch years you must:

	- get the new prices and cost to school
	- calculate price - cost = student profit
	- create new students_YEAR and products_YEAR tables
    - add the product info to products_YEAR
	- set $year=YEAR in page_defs.php

## TODO
	- on order entry page show running total in $$ and # items (js)
	- on students report have column headers stick on scroll down (js)
	- delete
		- fix it. seems to work on laptop but not server, so...
		- offer to undelete on the fruit_report?

## FUTURE ADD-ONS
	[]proper validation of input to delete??
	[]Proper data validation in process.php - only characters in fname/lname and only numbers in fruit
	[]Proper data validation in index.php - $_GET["id"] is pretty insecure currently
	[]User switchable years, which creates new table in database
	 (and switches to that for inserts and queries) must show up in totals and student report
	[*]Allow user to edit student's order via clickable links on students_report {Added 11/15/14 DL}
	[*]Tweak student report column headers for readability {Removed slant 11/22/14 DL}
	[*]delete functionality on students_report page {Added 11/28/15 DL}
	[*]NO meteorjs rewrites!! It's harder than you think and the data is much 
		easier to query in a MySQL db {11/28/15 DL}

## DISCLAIMER
	This code works well for me but no guarantees it will for you! Install/run at your own peril.