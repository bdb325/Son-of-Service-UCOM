<?php

/*
 * Son of Service
 * Copyright (C) 2003-2011 by Andrew Ziem.  All rights reserved.
 * Licensed under the GNU General Public License.  See COPYING for details.
 *
 * Updated and repurposed by Grand Valley Soluitons - Winter 2020 IS Capstone Group.
 *
 * Functions related to HTML, HTTP, and URLs.
 *
 * $Id: html.php,v 1.28 2011/12/21 04:32:25 andrewziem Exp $
 *
 */


if (preg_match('/html.php/i', $_SERVER['PHP_SELF']))
{
    die('Do not access this page directly.');
}

require_once(SOS_PATH . 'functions/access.php');
require_once(SOS_PATH . 'functions/functions.php');


function display_message($type, $message, $file, $line, $sql, $sql_error)
{
    global $debug;

    assert(is_int($type));
    switch ($type)
    {
    case MSG_SYSTEM_ERROR:
    case MSG_SYSTEM_WARNING:
    case MSG_USER_ERROR:
    case MSG_USER_WARNING:
        $class = " CLASS=\"errortext\"";
        break;
    default:
        $class = "";
        break;
    }
    echo ("<P$class>$message</P>");
    if ($debug)
    {
        if ($file != NULL && $line != NULL)
            echo ("<P>Location: $file line: $line</P>\n");
        if ($sql != NULL)
            echo ("<P>SQL: $sql</P>\n");

        if ($sql_error != NULL)
            echo ("<P>SQL Error: $sql_error</P>\n");
    }
}


/* display_message()
 * Displays a message previously stored with save_message().  Then erases
 * messages.
 *
 */
function display_messages()
{
    if (array_key_exists('messages', $_SESSION) and is_array($_SESSION['messages']) and count($_SESSION['messages']) > 0)
    {
    echo ("<DIV class=\"messages\">\n");
    // reverse array so FIFO
    $messages = array_reverse ($_SESSION['messages']);
    foreach ($messages as $key => $msg)
    {
        display_message($msg['type'], $msg['message'], $msg['file'], $msg['line'],
        $msg['sql'], $msg['sql_error']);
    }

    $_SESSION['messages'] = array();
    echo ("</DIV>\n");
    }

}

function make_nav_begin()
/* Builds a user navigation bar */
{
    if (is_printable())
    {
        // JavaScript print button
        echo ("<INPUT type=\"button\" value=\""._("Print")."\" onClick=\"window.print();\">\n");
        return;
    }
    echo ("<div class=\"tab_area noprint\">\n");
    echo ("<A class=\"tab\" href=\"". SOS_PATH . "src/search_volunteer.php\">"._("Search")."</A>\n");
    if (has_permission(PC_VOLUNTEER, PT_WRITE, NULL, NULL))
        echo ("<A class=\"tab\" href=\"". SOS_PATH . "src/add_volunteer.php\">"._("Add new volunteer")."</A>\n");
    echo ("<A class=\"tab\" href=\"". SOS_PATH . "src/reports.php\">"._("Reports")."</A>\n");

    if (has_permission(PC_ADMIN, PT_READ, NULL, NULL))
        echo ("<A class=\"tab\" href=\"". SOS_PATH ."admin/\">"._("Admin")."</A>\n");
    echo ("<A class=\"tab\" href=\"". SOS_PATH . "src/login.php?logout=1\">"._("Logout")."</A>\n");
    echo ("</DIV>\n");

// todo: make quick search fit aesthetically somewhere
/*
echo ("<FORM method=\"post\" action=\"". SOS_PATH . "src/search_volunteer.php\">\n");
echo ("Quick search <INPUT type=\"text=\" name=\"fullname\" size=\"10\">\n");
echo ("</FORM>\n");
*/

    if (preg_match('/\/volunteer\//i', $_SERVER['PHP_SELF']) and (array_key_exists('vid', $_GET) or array_key_exists('vid', $_POST)) and !array_key_exists('delete_confirm',$_POST))
    {
        $vid = $_REQUEST['vid'];

       echo ("<DIV class=\"tab_area noprint\">\n");
       echo ("This volunteer \n");
       echo ("<A class=\"tab\" href=\"". SOS_PATH . "volunteer/?vid=$vid\">"._("Summary")."</A>\n");
       echo ("<A class=\"tab\" href=\"". SOS_PATH . "volunteer/?vid=$vid&amp;menu=general\">"._("General")."</A>\n");
       echo ("<A class=\"tab\" href=\"". SOS_PATH . "volunteer/?vid=$vid&amp;menu=skills\">"._("Skills")."</A>\n");
       echo ("<A class=\"tab\" href=\"". SOS_PATH . "volunteer/?vid=$vid&amp;menu=availability\">"._("Availability")."</A>\n");
       echo ("<A class=\"tab\" href=\"". SOS_PATH . "volunteer/?vid=$vid&amp;menu=workhistory\">"._("Work history")."</A>\n");
       echo ("<A class=\"tab\" href=\"". SOS_PATH . "volunteer/?vid=$vid&amp;menu=notes\">"._("Notes")."</A>\n");
       echo ("<A class=\"tab\" href=\"". SOS_PATH . "volunteer/?vid=$vid&amp;menu=relationships\">"._("Relationships")."</A>\n");
       echo ("</DIV>\n");

    }

    echo ("<HR style=\"margin-top:0pt\" class=\"noprint\">\n");

} /* make_nav_begin() */



function make_html_begin($title, $options)
{
    set_up_language(NULL);

    echo ("<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\"");
    echo ("   \"http://www.w3.org/TR/html4/loose.dtd\">\n");
    echo ("<HTML>\n");
    echo ("<HEAD>\n");
	echo ("<meta http-equiv=\"Content-type\" content=\"text/html;charset=UTF-8\" />\n");
    echo ("<title>United Church Outreach Ministry :: Home</title>\n");
	echo ("<base href=\"http://ucomgr.org/\" />\n");
	echo ("<meta name=\"keywords\" content=\"ucom, ucomgr, united church outreach ministry, bruce roller, food pantry, grandville, wyoming\" />\n");
	echo ("<meta name=\"description\" content=\"United Church Outreach Ministry values individuals and builds community in southwestern Kent County by providing material and educational assistance to meet basic needs, improve quality of life, and promote self-sufficiency.\" />\n");
	echo ("<link href='http://fonts.googleapis.com/css?family=Arvo:regular,bold' rel='stylesheet' type='text/css' />\n");
	echo ("<link href=\"css/reset.css\" rel=\"stylesheet\" type=\"text/css\" media=\"screen\" />\n");
	echo ("<link href=\"js/fancybox/jquery.fancybox-1.3.4.css\" rel=\"stylesheet\" type=\"text/css\" media=\"screen\" />\n");
	echo ("<link href=\"css/superfish.css\" rel=\"stylesheet\" type=\"text/css\" media=\"screen\" />\n");
	echo ("<link href=\"css/custom-theme/jquery-ui-1.8.2.custom.css\" rel=\"stylesheet\" type=\"text/css\" media=\"screen\" />\n");
	echo ("<link href=\"css/styles_form.css\" rel=\"stylesheet\" type=\"text/css\" media=\"screen\" />\n");
	echo ("<link href=\"css/styles.css\" rel=\"stylesheet\" type=\"text/css\" media=\"screen\" />\n");
	echo ("<link href=\"css/events.css\" rel=\"stylesheet\" type=\"text/css\" media=\"screen\" />\n");
	echo ("<link href=\"css/styles_print.css\" rel=\"stylesheet\" type=\"text/css\" media=\"print\" />\n");
	echo ("<script type=\"text/javascript\" src=\"js/jquery-1.4.4.min.js\"></script>\n");
	echo ("<script type=\"text/javascript\" src=\"js/jquery-ui-1.8.7.custom.min.js\"></script>\n");
	echo ("<script type=\"text/javascript\" src=\"js/ui.datepicker.js\"></script>\n");
	echo ("<script type=\"text/javascript\" src=\"js/superfish.js\"></script>\n");
	echo ("<script type=\"text/javascript\" src=\"js/fancybox/jquery.fancybox-1.3.4.pack.js\"></script>\n");
	echo ("<script type=\"text/javascript\" src=\"js/jquery.example.min.js\"></script>\n");
	echo ("<script type=\"text/javascript\" src=\"js/jquery.history.js\"></script>\n");
	echo ("<script type=\"text/javascript\" src=\"js/jquery.cycle.all.min.js\"></script>\n");
	echo ("<script type=\"text/javascript\" src=\"js/jquery.easing.1.3.js\"></script>\n");
	echo ("<script type=\"text/javascript\" src=\"js/jquery.scrollTo-min.js\"></script>\n");
	echo ("<script type=\"text/javascript\" src=\"js/event.js\"></script>\n");
	echo ("<script type=\"text/javascript\" src=\"js/main.js\"></script>\n");
	echo ("<script src=\"http://www.google.com/jsapi?key=ABQIAAAAb6q6xJDQ-u0-AIeIP2y3uBRD5ypSX9jBDObf2iytwl7Q_GeWjxTteugvXj1LmOXN4p50Y9-7kkRRIQ\" type=\"text/javascript\"></script>
	<script language=\"Javascript\" type=\"text/javascript\">
		var q='';
		if(q==''){
			 q='search';
		}

		google.load('search', '1');  
		var searchControl;
		function OnLoad() {		  
			// Create a search control
			var searchControl = new google.search.SearchControl();
			google.search.Search.getBranding(document.getElementById(\"branding\"));
			
			var options = new google.search.SearcherOptions();
			options.setExpandMode(google.search.SearchControl.EXPAND_MODE_OPEN);							
			
			var siteSearch = new google.search.WebSearch();
			siteSearch.setUserDefinedLabel(\"United Church Outreach Ministry\");
			siteSearch.setUserDefinedClassSuffix(\"siteSearch\");
			siteSearch.setSiteRestriction(\"ucomgr.org\");
			siteSearch.setResultSetSize(google.search.Search.LARGE_RESULTSET);
			// call the Websearch with options and restricted to alert labs
			searchControl.addSearcher(siteSearch,options);

			// set linear mode optoin		
			var drawOptions = new google.search.DrawOptions();
			drawOptions.setDrawMode(google.search.SearchControl.DRAW_MODE_LINEAR);
			drawOptions.setInput(document.getElementById('q'));

			// where to draw/show with include above options
			searchControl.draw(document.getElementById(\"search_results\"),drawOptions);
			//alert(q);
			// execute the search from the $_POST
			searchControl.execute(q);	
		}
		google.setOnLoadCallback(OnLoad);
		
		$(document).ready(function(){
			
			// keep the search query in the box
			$('#searchText').val(q);
			
			// remove text from box when clicked in
			$('#searchText').focus(function(){	
				$(this).val('');
			});

			$('#searchText').change(function(){		
				$('#searchForm').submit();
			});	
		});
		</script>\n");
	echo ("<script type=\"text/javascript\" src=\"http://w.sharethis.com/button/sharethis.js#publisher=473a9a6e-bd6c-46ed-8244-39ad1036c01e&amp;type=website&amp;embeds=false&amp;post_services=email%2Cfacebook%2Ctwitter%2Cgbuzz%2Cmyspace%2Cdigg%2Csms%2Cwindows_live%2Cdelicious%2Cstumbleupon%2Creddit%2Cgoogle_bmarks%2Clinkedin%2Cbebo%2Cybuzz%2Cblogger%2Cyahoo_bmarks%2Cmixx%2Ctechnorati%2Cfriendfeed%2Cpropeller%2Cwordpress%2Cnewsvine&amp;button=false\"></script>\n");
	echo ("<style>
       .btn-white {
   			 color: #333333;
    		background-color: #FFFFFF;
    		border-color: #F0F0F0;
    		background: -webkit-gradient(linear, left top, left bottom, from(#FFFFFF), to(#F0F0F0));
    		background: linear-gradient(to bottom, #FFFFFF 0%, #F0F0F0 100%);
    		text-decoration: none;
		}

		.btn {
			font-family:Arvo, serif;
			display: inline-block;
			font-weight: 400;
			text-align: center;
			white-space: nowrap;
			vertical-align: middle;
			-webkit-user-select: none;
			-moz-user-select: none;
			-ms-user-select: none;
			user-select: none;
			border: 1px solid transparent;
			padding: 0.250rem 0.75rem;
			font-size: 1rem;
			line-height: 1.6;
			border-radius: 0.25rem;
			-webkit-transition: background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, -webkit-box-shadow 0.15s ease-in-out;
			transition: background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, -webkit-box-shadow 0.15s ease-in-out;
			transition: background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
			transition: background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out, -webkit-box-shadow 0.15s ease-in-out;
		}

		.btn.newsletter {
			width:196px;
			border-radius: 8px;
			 padding:2px 0;
		}
		.newsletter-signup {
			margin-top:10px;
		}
    </style>\n");
	echo ("<STYLE type=\"text/css\" media=\"screen\">\n");
    echo ("<!--   @import url(". SOS_PATH. "sos.css);  -->  \n");
    echo ("</STYLE>\n");
    echo ("<STYLE type=\"text/css\" media=\"print\">\n");
    echo ("  <!--  .noprint {display:none}  -->\n");
    echo ("</STYLE>\n");
    echo ("<META name=\"robots\" content=\"noindex,nofollow\">\n");
    echo ("<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">\n");
    echo ("</HEAD>\n");
    echo ("<BODY>\n");
	echo ("<div id=\"wrapper\">
		 <img src=\"layout_imgs/ucomgr-header-logo.png\" alt=\"UCOM\" width=\"315\" height=\"193\" style=\"position:absolute;top:0px;left:15px;z-index:10;\" />
		<div id=\"topbar\">
			<div id=\"searchbox\">
				<form action=\"search_results.php\" method=\"post\" id=\"searchForm\"   >
					<input type=\"text\" name=\"searchText\" id=\"searchText\" value=\"search the site\"   />	
					<input type=\"submit\" name=\"Submit\" id=\"search-submit\" value=\"\"   />	
				</form>
			</div>
		</div>
		<div id=\"header\">
			 <img src=\"layout_imgs/ucom_header_text.png\" alt=\"UCOM\" width=\"356\" height=\"119\" style=\"position:absolute;top:8px;left:330px;\" />
				
			<div class=\"social_icons\" >
				<a href=\"http://www.facebook.com/pages/United-Church-Outreach-Ministry-UCOM/104853154275\" title=\"Find us on Facebook\"><img src=\"layout_imgs/icon_facebook32.png\" alt=\"\" width=\"32\" height=\"32\" style=\"margin:0 4px;\" /></a>
				<a href=\"http://www.twitter.com/UCOM_GR\" title=\"Follow UCOM_GR on Twitter\"><img src=\"layout_imgs/icon_twitter32.png\" alt=\"\" width=\"32\" height=\"32\"  style=\"margin:0 4px;\" /></a>
				<a href=\"http://www.twitter.com/BruceRoller\" title=\"Follow BruceRoller on Twitter\"><img src=\"layout_imgs/icon-twitter32-circle.png\" alt=\"\" width=\"32\" height=\"32\"  style=\"margin:0 4px;\" /></a>
				<a href=\"contact\" title=\"Contact Us\"><img src=\"layout_imgs/icon_mail.png\" alt=\"\" width=\"32\" height=\"32\"  style=\"margin:0 4px;\" /></a>
				
				
				<a id=\"ck_sharethis_home\" class=\"stbar chicklet\" href=\"javascript:void(0);\" title=\"Share This\" ><img src=\"layout_imgs/icon_share32.png\" alt=\"\" width=\"32\" height=\"32\"  style=\"margin:0 4px;\" /></a>
				<script type=\"text/javascript\">
						var shared_object = SHARETHIS.addEntry({
							title: \"Home\",
							url: document.location.href+'home'
						});
					shared_object.attachButton(document.getElementById(\"ck_sharethis_home\"));
					</script>				
				<br />				
				<p class=\"donate\"><a href=\"https://donatenow.networkforgood.org/UCOMgr\" title=\"Donate\" ><img src=\"layout_imgs/icon-donate-green.png\" alt=\"\" width=\"200\" height=\"35\" /></a>
				</p>		
			    <div class=\"newsletter-signup\">
               		<p><a href=\"/emaillistjoin\" class=\"btn btn-white newsletter\">Keep in Touch</a></p>
            	</div>									
			</div>	
		</div>\n");
	echo ("<div id=\"menu\">
			<ul id=\"nav\" class=\"sf-menu\">
				<li><a href=\"home\" title=\"Home\"  id=\"home\" >Home</a></li><li><a href=\"about\" title=\"About\"  id=\"about\" >About</a><ul><li><a href=\"partners\" title=\"Community Partners\"  id=\"partners\" >Community Partners</a></li><li><a href=\"hours\" title=\"Hours and Eligibility\"  id=\"hours\" >Hours and Eligibility</a></li><li><a href=\"mission\" title=\"Mission and Values\"  id=\"mission\" >Mission and Values</a></li><li><a href=\"Ourteam\" title=\"Our Team\"  id=\"Ourteam\" >Our Team</a><ul><li><a href=\"staff\" title=\"Staff\"  id=\"staff\" >Staff</a></li><li><a href=\"board\" title=\"Board\"  id=\"board\" >Board</a></li></ul></li><li><a href=\"history\" title=\"History\"  id=\"history\" >History</a></li><li><a href=\"http://ucomgr.org/uploads/files/AnnualReport2019.pdf\" title=\"Annual Report\"  id=\"http://ucomgr.org/uploads/files/AnnualReport2019.pdf\" >Annual Report</a></li><li><a href=\"diversity\" title=\"Commitment to Diversity\"  id=\"diversity\" >Commitment to Diversity</a></li><li><a href=\"healthyfood\" title=\"UCOM Healthy Food Policy\"  id=\"healthyfood\" >UCOM Healthy Food Policy</a></li></ul></li><li><a href=\"news-events\" title=\"News/Events\"  id=\"news-events\" >News/Events</a><ul><li><a href=\"newsletters\" title=\"Newsletters\"  id=\"newsletters\" >Newsletters</a><ul><li><a href=\"http://ucomgr.org/uploads/files/Winter2020.pdf\" title=\"Winter '20 Newsletter\"  id=\"http://ucomgr.org/uploads/files/Winter2020.pdf\" >Winter '20 Newsletter</a></li><li><a href=\"http://ucomgr.org/uploads/files/Fall2019.pdf\" title=\"Fall '19 Newsletter\"  id=\"http://ucomgr.org/uploads/files/Fall2019.pdf\" >Fall '19 Newsletter</a></li><li><a href=\"http://ucomgr.org/uploads/files/Summer2019.pdf\" title=\"Summer '19 Newsletter\"  id=\"http://ucomgr.org/uploads/files/Summer2019.pdf\" >Summer '19 Newsletter</a></li><li><a href=\"http://ucomgr.org/uploads/files/Spring2019.pdf\" title=\"Spring '19 Newsletter\"  id=\"http://ucomgr.org/uploads/files/Spring2019.pdf\" >Spring '19 Newsletter</a></li></ul></li><li><a href=\"directors_blog\" title=\"Bruce's Blog\"  id=\"directors_blog\" >Bruce's Blog</a></li><li><a href=\"events\" title=\"Events\"  id=\"events\" >Events</a></li><li><a href=\"concert2020\" title=\"17th Annual Friends of UCOM Benefit Concert\"  id=\"concert2020\" >17th Annual Friends of UCOM Benefit Concert</a></li></ul></li><li><a href=\"programs\" title=\"Programs\"  id=\"programs\" >Programs</a><ul><li><a href=\"food\" title=\"Food Support\"  id=\"food\" >Food Support</a><ul><li><a href=\"foodpantry\" title=\"Healthy Choice Food Pantry\"  id=\"foodpantry\" >Healthy Choice Food Pantry</a></li><li><a href=\"farmstand\" title=\"UCOM Farm Stand\"  id=\"farmstand\" >UCOM Farm Stand</a></li><li><a href=\"ggn\" title=\"Growing Green Neighbors\"  id=\"ggn\" >Growing Green Neighbors</a><ul><li><a href=\"sfg\" title=\"Square Foot Gardening\"  id=\"sfg\" >Square Foot Gardening</a></li><li><a href=\"projectfresh\" title=\"Project Fresh\"  id=\"projectfresh\" >Project Fresh</a></li></ul></li></ul></li><li><a href=\"clothing\" title=\"Clothing Pantry\"  id=\"clothing\" >Clothing Pantry</a></li><li><a href=\"financial_literacy\" title=\"Financial Literacy\"  id=\"financial_literacy\" >Financial Literacy</a></li><li><a href=\"health_screening\" title=\"Health Screening\"  id=\"health_screening\" >Health Screening</a></li><li><a href=\"work_skills\" title=\"Work Skills Training Site\"  id=\"work_skills\" >Work Skills Training Site</a></li></ul></li><li><a href=\"get_involved\" title=\"Get Involved\"  id=\"get_involved\" >Get Involved</a><ul><li><a href=\"donate\" title=\"Donate\"  id=\"donate\" >Donate</a></li><li><a href=\"emaillistjoin\" title=\"E-Mailing List\"  id=\"emaillistjoin\" >E-Mailing List</a></li><li><a href=\"missiongroups\" title=\"Mission Groups\"  id=\"missiongroups\" >Mission Groups</a></li><li><a href=\"volunteer\" title=\"Volunteer\"  id=\"volunteer\" >Volunteer</a></li><li><a href=\"employment\" title=\"Employment Opportunities\"  id=\"employment\" >Employment Opportunities</a></li><li><a href=\"needs\" title=\"Needs\"  id=\"needs\" >Needs</a></li></ul></li><li><a href=\"links\" title=\"Links\"  id=\"links\" >Links</a></li><li><a href=\"contact\" title=\"Contact Us\"  id=\"contact\" >Contact Us</a></li>			</ul>	
		</div>\n");

}


function make_html_end()
{
			echo ("	<div id=\"footer\">
				<div class=\"clear\"></div>
			
			<table id=\"address\">
			<tbody>
				<tr>
					<td colspan=\"2\" style=\"font-size:14px;padding-bottom:10px;\">A Covenanted Ministry of the Michigan Conference of the United Church of Christ</td>
				</tr>
				<tr>
					<td style=\"width:50%;font-size:13px;\">United Church Outreach Ministry<br />1311 Chicago&nbsp;Dr&nbsp;SW<br />Wyoming,&nbsp;MI&nbsp;49509 </td>
					<td  style=\"width:50%;font-size:13px;\">
						phone:  (616) 241-4006 <br />
						fax:  (616) 241-3343
					</td>
				</tr>
			</tbody>
			</table>
			<div id=\"footer-logos\">
				<a href=\"http://www.hwmuw.org\" target=\"_blank\"><img src=\"layout_imgs/HWMUW-LOGO.png\" alt=\"hwmuw logo\" /></a>
				<a href=\"http://prfc-gr.org/\" target=\"_blank\"><img src=\"layout_imgs/Logo-prfc.png\" alt=\"prcf logo\" /></a><br />
				<a href=\"https://www.chhsm.org/\" target=\"_blank\"><img src=\"layout_imgs/CHHSM-Logo.png\" alt=\"chhsm logo\" /></a>
			</div>
			<div class=\"clear\"></div>
 	</div><!-- close footer -->
</div><!-- close wrapper -->\n");
  

    }
function public_html_end()
    {


    ?>
    </BODY>
    <footer>
      <h1> Returning Volunteers Click  <a href="clock.php">Here</a> </h1>
      <h3> Admins login <a href="login.php">Here</a> </h3>
    </footer>
    </HTML>
    <?php

        }


function display_position_option($arg_1, $arg_2)
// deprecated
{
  if ($arg_1 == $arg_2)
    return "value=\"$arg_1\" SELECTED";
  else
    return "value=\"$arg_1\" ";
}


function make_url($parameters, $exclusion)
// paramaters: an array, such as $_GET
// exclusion: keys not to include from parameters (string or array)
// return: url suitable for HREF
{
    assert(is_array($parameters));
    assert(is_array($exclusion) or is_string($exclusion));
    $url = "";
    $url_i = 0;
    if (is_string($exclusion))
        $exclusion = array($exclusion);
    foreach ($parameters as $k => $v)
    {
        $excluded = FALSE;
        if (is_array($exclusion))
        {
            foreach ($exclusion as $e)
            {
                if ($e == $k)
                    $excluded = TRUE;
            }
        }
        if (!$excluded)
        {
            if (0 == $url_i)
                $url .= '?';
            else
                $url .= '&amp;';
            $url .= urlencode("$k").'='.urlencode("$v");
            $url_i++;
        }
    }
    return $url;
}

function find_values_in_request($request, $prefix)
// Finds integers in a form request by searching for keys beginning
// with prefix.  Returns the integer part only.  Useful for processing
// input from multiple choice forms.

// $request: an array such $_POST
// $prefix: a string such as volunteer_id
// return: an array of integers
{
    assert(is_array($request));
    assert(is_string($prefix));
    $ret = array();
    foreach ($_POST as $key => $value)
    {
        if (preg_match("/${prefix}_(\d+)/", $key, $matches))
            $ret[] = $matches[1];
    }
    return ($ret);
}

function nbsp_if_null($s)
{
    if (NULL == $s or 0 == strlen($s))
        return "&nbsp;";
    return $s;
}

function is_printable()
{
    return (array_key_exists('printable', $_GET));
}

?>
