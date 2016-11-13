<?php
/*
 * delete.php
 * students_report sends this an ID and we delete it and return
 */
require_once "page_defs.php";

$mysqli = db_conn(); //from page_defs
$id = $_POST["id"]; //TODO- secure this. currently pulls in unfiltered id. 
// query database for each student and their sales
$query = $mysqli->prepare('DELETE FROM '. $students_table . ' WHERE ID=' . $id . ' LIMIT 1');
$query->execute();
$mysqli->close();
header('Location: students_report.php');
die();
// no closing tag
