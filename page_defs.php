<?php

/*
* first define the array of all fruit items
* key = mysql table name, value = full name for frontend label purposes
* amount from student table of whatever year we're in
* price and profit from line in years table 
 */

//@TODO get price and profit from years table once then update on year change. 
$fruit_items = array("navel_orang_full" => array("name" => "Navel Oranges Full Box", "price" => 0.00, "profit" => 0.00),
	 				 "navel_orang_half" => array("name" => "Navel Oranges Half Box", "price" => 0.00, "profit" => 0.00),
					 "red_grape_full" => array("name" => "Red Grapefruit Full Box", "price" => 0.00, "profit" => 0.00),
					 "red_grape_half" => array("name" => "Red Grapefruit Half Box", "price" => 0.00, "profit" => 0.00),
					 "grann_smith_full" => array("name" => "Granny Smith Full Box", "price" => 0.00, "profit" => 0.00),
					 "grann_smith_half" => array("name" => "Granny Smith Half Box", "price" => 0.00, "profit" => 0.00),
					 "red_delic_full" => array("name" => "Red Delicious Full Box", "price" => 0.00, "profit" => 0.00),
					 "red_delic_half" => array("name" => "Red Delicious Half Box", "price" => 0.00, "profit" => 0.00),
				     "golde_delic_full" => array("name" => "Golden Delicious Full Box", "price" => 0.00, "profit" => 0.00),
					 "golde_delic_half" => array("name" => "Golden Delicious Half Box", "price" => 0.00, "profit" => 0.00),
				     "braeb_full" => array("name" => "Braeburn Full Box", "price" => 0.00, "profit" => 0.00),
				     "braeb_half" => array("name" => "Braeburn Half Box", "price" => 0.00, "profit" => 0.00),
				     "danjo_pears_full" => array("name" => "D'Anjou Full Box", "price" => 0.00, "profit" => 0.00),
				     "danjo_pears_half" => array("name" => "D'Anjou Half Box", "price" => 0.00, "profit" => 0.00),
					 "mixed_a" => array("name" => "Mixed Box A", "price" => 0.00, "profit" => 0.00),
				     "mixed_b" => array("name" => "Mixed Box B", "price" => 0.00, "profit" => 0.00),
					 "mixed_c" => array("name" => "Mixed Box C", "price" => 0.00, "profit" => 0.00),
					 "mixed_d" => array("name" => "Mixed Box D", "price" => 0.00, "profit" => 0.00),
				     "gift_l" => array("name" => "Gift Box L", "price" => 0.00, "profit" => 0.00),
				     "gift_s" => array("name" => "Gift Box S", "price" => 0.00, "profit" => 0.00),
					 "gift_lp" => array("name" => "Gift Box LP", "price" => 0.00, "profit" => 0.00),
				     "gift_sp" => array("name" => "Gift Box SP", "price" => 0.00, "profit" => 0.00),
					 "pinea" => array("name" => "Pineapple", "price" => 0.00, "profit" => 0.00));
/*
* Page definition variables. Used to build consistent site head, header/navigation, and footer.
*  repurposed from portfolio site. because reasons....
*/

function page_head($page_title) {
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

$footer = "<footer>
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

// possibly the most important value of all: what year are we using?
$year = 2015;

// no closing tag
