<?php

  /*
   * first define the array of all fruit items
   * key = mysql table name, value = full name for frontend label purposes
   */
$fruit_items = array("naval_orang_full" => array("name" => "Naval Oranges Full Box",
												 "amount" => 0),
	 				 "naval_orang_half" => array("name" => "Naval Oranges Half Box",
												 "amount" => 0),
					 "red_grape_full" => array("name" => "Red Grapefruit Full Box",
											   "amount" => 0),
					 "red_grape_half" => array("name" => "Red Grapefruit Half Box",
											   "amount" => 0),
					 "grann_smith_full" => array("name" => "Granny Smith Full Box",
												 "amount" => 0),
					 "grann_smith_half" => array("name" => "Granny Smith Half Box",
												 "amount" => 0),
					 "red_delic_full" => array("name" => "Red Delicious Full Box",
											   "amount" => 0),
					 "red_delic_half" => array("name" => "Red Delicious Half Box",
											   "amount" => 0),
				     "golde_delic_full" => array("name" => "Golden Delicious Full Box",
												 "amount" => 0),
					 "golde_delic_half" => array("name" => "Golden Delicious Half Box",
												 "amount" => 0),
				     "braeb_full" => array("name" => "Braeburn Full Box",
										   "amount" => 0),
				     "braeb_half" => array("name" => "Braeburn Half Box",
										   "amount" => 0),
				     "danjo_pears_full" => array("name" => "D'Anjou Full Box",
												 "amount" => 0),
				     "danjo_pears_half" => array("name" => "D'Anjou Half Box",
												 "amount" => 0),
					 "mixed_a" => array("name" => "Mixed Box A", 
										"amount" => 0),
				     "mixed_b" => array("name" => "Mixed Box B",
										"amount" => 0),
					 "mixed_c" => array("name" => "Mixed Box C", 
										"amount" => 0),
					 "mixed_d" => array("name" => "Mixed Box D",
										"amount" => 0),
				     "gift_l" => array("name" => "Gift Box L", 
										"amount" => 0),
				     "gift_s" => array("name" => "Gift Box S",
									   "amount" => 0),
					 "gift_lp" => array("name" => "Gift Box LP",
									    "amount" => 0),
				     "gitf_sp" => array("name" => "Gift Box SP",
										"amount" => 0),
					 "pinea" => array("name" => "Pineapple",
									  "amount" => 0));
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
</head>
<body>
";
}

$footer = "<footer>
	<p>Oostburg Parents Music Club Fruit Sale Counting App<br>
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

  //start the header
  $header_nav = "<header>
		<h1>OPMC Fruit Sale Counting App</h1>
</header>
<nav>
  <ul>
	  ";

  //one variable for each nav item
  $index_link = "<li><a href='index.php'>Order Entry</a></li>\n";
  $totals_link = "<li><a href='totals.php'>Totals</a></li>\n";
  $students_report_link = "<li><a href='students_report.php'>Students Report</a></li>\n";

  //figure out which page is active and add a class to it
  $page_var = $curr_page . "_link";
  $$page_var = "<li><a id='active_page' " . substr($$page_var, 7);

  //concatenate strings to add nav items
  $header_nav .= $index_link . $totals_link . $students_report_link;

  //close ending tags
  $header_nav .= "</ul>
			  </nav>";

  return $header_nav;
}

?>
