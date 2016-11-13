<?php
// enable PHP ridiculous error reporting - disable in prod!
error_reporting(-1);
ini_set('display_errors', 'On');

require_once "db_config.php"; // db connection info

$year = 2015; // defines which tables to read from. 

/*
* build array of all fruit items
* key = mysql table name, value = full name for frontend label purposes
* amount from student table of whatever year we're in
* price and profit from line in years table 
 */


//@TODO get price and profit from years table once then update on year change. 
$fruit_items = array("navel_orang_full" => array("name" => "Navel Oranges Full Box", "price" => 0.00, "profit" => 0.00, "amount" => 0),
	 				 "navel_orang_half" => array("name" => "Navel Oranges Half Box", "price" => 0.00, "profit" => 0.00, "amount" => 0),
					 "red_grape_full" => array("name" => "Red Grapefruit Full Box", "price" => 0.00, "profit" => 0.00, "amount" => 0),
					 "red_grape_half" => array("name" => "Red Grapefruit Half Box", "price" => 0.00, "profit" => 0.00, "amount" => 0),
					 "grann_smith_full" => array("name" => "Granny Smith Full Box", "price" => 0.00, "profit" => 0.00, "amount" => 0),
					 "grann_smith_half" => array("name" => "Granny Smith Half Box", "price" => 0.00, "profit" => 0.00, "amount" => 0),
					 "red_delic_full" => array("name" => "Red Delicious Full Box", "price" => 0.00, "profit" => 0.00, "amount" => 0),
					 "red_delic_half" => array("name" => "Red Delicious Half Box", "price" => 0.00, "profit" => 0.00, "amount" => 0),
				     "golde_delic_full" => array("name" => "Golden Delicious Full Box", "price" => 0.00, "profit" => 0.00, "amount" => 0),
					 "golde_delic_half" => array("name" => "Golden Delicious Half Box", "price" => 0.00, "profit" => 0.00, "amount" => 0),
				     "braeb_full" => array("name" => "Braeburn Full Box", "price" => 0.00, "profit" => 0.00, "amount" => 0),
				     "braeb_half" => array("name" => "Braeburn Half Box", "price" => 0.00, "profit" => 0.00, "amount" => 0),
				     "danjo_pears_full" => array("name" => "D'Anjou Full Box", "price" => 0.00, "profit" => 0.00, "amount" => 0),
				     "danjo_pears_half" => array("name" => "D'Anjou Half Box", "price" => 0.00, "profit" => 0.00, "amount" => 0),
					 "mixed_a" => array("name" => "Mixed Box A", "price" => 0.00, "profit" => 0.00, "amount" => 0),
				     "mixed_b" => array("name" => "Mixed Box B", "price" => 0.00, "profit" => 0.00, "amount" => 0),
					 "mixed_c" => array("name" => "Mixed Box C", "price" => 0.00, "profit" => 0.00, "amount" => 0),
					 "mixed_d" => array("name" => "Mixed Box D", "price" => 0.00, "profit" => 0.00, "amount" => 0),
				     "gift_l" => array("name" => "Gift Box L", "price" => 0.00, "profit" => 0.00, "amount" => 0),
				     "gift_s" => array("name" => "Gift Box S", "price" => 0.00, "profit" => 0.00, "amount" => 0),
					 "gift_lp" => array("name" => "Gift Box LP", "price" => 0.00, "profit" => 0.00, "amount" => 0),
				     "gift_sp" => array("name" => "Gift Box SP", "price" => 0.00, "profit" => 0.00, "amount" => 0),
                     "pinea" => array("name" => "Pineapple", "price" => 0.00, "profit" => 0.00, "amount" => 0));
// query for fruit items table
/*
// make this a function! 
// if certain parameter, leave amount = 0. this is for the entry page.
// if another parameter, amount must equal values from students_* table

// connect to db and test conn
$mysqli = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE, DB_PORT);
if ($mysqli->connect_errno) { 
	die(" $mysqli->connect_errno: $mysqli->connect_error"); 
}
// setup retrieve all tables query
$tables_query = "SHOW TABLES FROM " . DB_DATABASE;
$tables_stmt = $mysqli->stmt_init();
$output = "<p>Here are all the tables in the database:</p>";

if(!$tables_stmt->prepare($tables_query)){
	echo "failed to prepare tables statement";
} else {
	// run select all tables query and get results
	$tables_stmt->execute();
	$results = $tables_stmt->get_result();
	$tables_stmt->close();

	// loop through all table names, selecting * from each 
	while($result_arr = $results->fetch_array(MYSQLI_NUM )){
		// open new query to get single table
		$ot_stmt = $mysqli->stmt_init();
		$table_name = $result_arr[0];
		$ot_query = "SELECT * FROM $table_name";
		if(!$ot_stmt->prepare($ot_query)){
			echo "failed to prepare one table statement";
		} else {
			$ot_stmt->execute();
			$ot_results = $ot_stmt->get_result();
			
			$output .= "<table>\n<thead><tr><th>\n\t<h3>$table_name</h3>\n</th></tr>\n";
			$first_run = true;
			while($ot_res_arr = $ot_results->fetch_array(MYSQLI_ASSOC)){

				if ($first_run){
					// set column headers
					$output .= "<tr>\n\t";
					$columns = array_keys($ot_res_arr);
					foreach($columns as $column){
						$output .= "<th>$column</th>";
					}
					$output .= "\n</tr></thead>";
					$first_run = false;
				}
				// add data elements to table
				$output .= "<tr>";
				foreach($ot_res_arr as $res){
					$output .= "<td>$res</td>";
				}
				$output .= "</tr>";
			}
			$output .= "</table>\n<a href=\"#\">^return to top</a>\n";
			// close single table query
			$ot_stmt->close();
		}
	}
}

$mysqli->close(); // close db conn
 */




/* Page definition variables. Used to build consistent site head, header/navigation, and footer. */
function page_head($page_title) {
    /*
     * given page title, returns head with proper title string
     */
    return "<!doctype html>
<html lang=\"en\">
<head>
	<meta charset=\"utf-8\">
	<title>$page_title</title>
	<meta name=\"viewport\" content=\"width=device-width; initial-scale=1.0\">
	<link rel=\"stylesheet\" href=\"fruit_style.css\"  media=\"only screen\" >
	<link rel=\"stylesheet\" href=\"fruit_print.css\"  media=\"print\" >
</head>
<body>
";
}

$footer = "\n<footer>
	<p>Oostburg Parents Music Club Fruit Counter<br>
   by Dan Leitzke 2014 - " . date("Y") . " drleitzke[at]gmail[dot]com<br>
	</p>
</footer>
</body>
</html>
      ";

function get_header_nav($curr_page) {
  /*
   * determine header+navigation based on current page
   */

  // start the header
  $header_nav = "<header>
		<h1>OPMC Fruit Counter</h1>
</header>
<nav>
  <ul>
	  ";

  // one variable for each nav item
  $index_link = "<li><a href='index.php'>Order Entry</a></li>\n";
  $totals_link = "<li><a href='totals.php'>Totals</a></li>\n";
  $students_report_link = "<li><a href='students_report.php'>Students Report</a></li>\n";

  // figure out which page is active and add a class to it
  $page_var = $curr_page . "_link";
  $$page_var = "<li><a id='active_page' " . substr($$page_var, 7);

  // concatenate strings to add nav items
  $header_nav .= $index_link . $totals_link . $students_report_link;

  // close ending tags
  $header_nav .= "</ul>
</nav>";

  return $header_nav;
}

// no closing tag
