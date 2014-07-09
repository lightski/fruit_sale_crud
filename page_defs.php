<?php

  /*
   * first define the array of all fruit items
   * key = mysql table name, value = full name for frontend label purposes
   */
  $fruit_items = array("naval_orang_full" =>"Naval Oranges Full Box",
                       "naval_orang_half" => "Naval Oranges Half Box",
                       "red_grape_full" => "Red Grapefruit Full Box",
                       "red_grape_half" => "Red Grapefruit Half Box",
                       "grann_smith_full" => "Granny Smith Full Box",
                       "grann_smith_half" => "Granny Smith Half Box",
                       "red_delic_full" => "Red Delicious Full Box",
                       "red_delic_half" => "Red Delicious Half Box",
                       "golde_delic_full" => "Golden Delicious Full Box",
                       "golde_delic_half" => "Golden Delicious Half Box",
                       "braeb_full" => "Braeburn Full Box",
                       "braeb_half" => "Braeburn Half Box",
                       "danjo_pears_full" => "D'Anjou Full Box",
                       "danjo_pears_half" => "D'Anjou Half Box",
                       "mixed_a" => "Mixed Box A", "mixed_b" => "Mixed Box B",
                       "mixed_c" => "Mixed Box C", "mixed_d" => "Mixed Box D",
                       "gift_l1" => "Gift Box L", "gift_s" => "Gift Box S",
                       "gift_lp" => "Gift Box LP", "gitf_sp" => "Gift Box SP",
                       "pinea" => "Pineapple");
  /*
   * Page definition variables. Used to build consistent site head, header/navigation, and footer.
   *  repurposed from portfolio site. because reasons....
   */

$head =  '<meta charset="utf-8">
    <meta name="viewport" content="width=device-width; initial-scale=1.0">
	  <link rel="stylesheet" href="fruit_style.css"  media="only screen" >
	  ';


$footer = " <footer>
		<p>Oostburg Parents Music Club Fruit Sale Counting WebApp<br>
       by Dan Leitzke 2014 - " . date("Y") . " drleitzke[at]gmail[dot]com<br>
		</p>
	   	</footer>
      ";

function getHeaderNav($currPage) {
  /*
   * determine header+navigation based on current page
   */

  //start the header
  $headerNav = "<header>
	            <h1>OPMC Fruit Sale Counting App</h1>
        </header>
	      <nav>
 		    <ul>\n";

  //one variable for each nav item
  $indexLink = "<li><a href='index.php'>Order Entry</a></li>\n";
  $totalsLink = "<li><a href='totals.php'>Totals</a></li>\n";

  //figure out which page is active and add a class to it
  $pageVar = $currPage . "Link";
  $$pageVar = "<li><a id='activePage' " . substr($$pageVar, 7);

  //concatenate strings to add nav items
  $headerNav .= $indexLink . $totalsLink;

  //close ending tags
  $headerNav .= "	</ul>
 	                  </nav>";

  return $headerNav;
}

?>
