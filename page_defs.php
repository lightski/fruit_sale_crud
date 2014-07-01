<?php
  /*
   * Page definition variables. Used to build consistent site head, header/navigation, and footer.
   *  repurposed from portfolio site. because reasons....
   */

$head =  '<meta charset="utf-8">
    <meta name="viewport" content="width=device-width; initial-scale=1.0">
	  <link rel="stylesheet" href="portfolio_style.css"  media="only screen" >
	  ';


$footer = " <footer>
		<p>Oostburg Schools Fruit sale Counting WebApp<br>
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
