<?php
/*
 * delete.php
 * students_report sends this an ID and we delete it and return
 */
require_once "page_defs.php";
require_once "db_config.php";

// enable PHP ridiculous error reporting
error_reporting(-1);
ini_set('display_errors', 'On');

// connecting to db
$mysqli = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE, DB_PORT);
// check db connection
if ($mysqli->connect_errno) {
  echo "Connection Failed: " . $mysqli->connect_error;
  die();
}

$id = $_POST["id"]; //TODO- secure this. currently pulls in unfiltered id. 
// query database for each student and their sales
$query = $mysqli->prepare('DELETE FROM students_fruit_' . $year . ' WHERE ID=' . $id . ' LIMIT 1');
$query->execute();
$mysqli->close();
header('Location: students_report.php');
die();
// no closing tag
