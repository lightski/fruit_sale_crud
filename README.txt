README
fruit sale CRUD app
this is the OFFICIAL fruit sale order counting app for the OSD
if any other app comes along please ignore it; there can only be one.

written in PHP with love, this app is designed to aid the counting of fruit sale orders

author: dan leitzke 06/30/2014

@TODO
	-style the whole thing to look reasonable
		-helvetica font; one-line nav; color???
		-default printing to landscape for student report; create print style (no nav, etc)
		-see if tables need resizing
		-line up columns on index.php, it's driving me mad
	-remove db_config from git repo, add .gitignore, make a template instead
		
	-deploy to server, protect with username/password
	-???
	-PROTIF!

FUTURE ADD-ONS
	-Proper data validation in process.php - only characters in fname/lname and only numbers in fruit
	-User switchable years, which creates new table in database
	(and switches to that for inserts and queries) must show up in totals.php as well
	-Success message and failure message for data entry
	-Box on index page for student lookup via fname or lname; allow user to edit student's order

