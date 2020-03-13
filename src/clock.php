<?php

/*
 * Son of Service
 * Copyright (C) 2003-2009 by Andrew Ziem.  All rights reserved.
 * Licensed under the GNU General Public License.  See COPYING for details.
 *
 * Updated and repurposed by Grand Valley Soluitons - Winter 2020 IS Capstone Group.
 *
 * $Id: add_volunteer.php,v 1.19 2009/02/13 03:52:15 andrewziem Exp $
 *
 */

ob_start();
session_start();

define('SOS_PATH', '../');

require_once (SOS_PATH . 'include/global.php');
require_once (SOS_PATH . 'include/config.php');
require_once (SOS_PATH . 'functions/html.php');


make_html_begin(_("Log Volunteer Hours"), array());

$servername = "database-1.cbkwsq59mx5a.us-east-1.rds.amazonaws.com";
$username = "admin";
$password = "lDWUp2cbP3ub6FMIHZYf";
$db = "sos";
// Create connection
$con = new mysqli($servername, $username, $password, $db);


// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// note need to add two php codes. clock in and clock out
$first = mysqli_real_escape_string($_REQUEST['first']);
$middle = mysqli_real_escape_string($_REQUEST['middle']);
$last = mysqli_real_escape_string($_REQUEST['last']);
$sql = "SELECT first,middle,last FROM volunteers WHERE first = $first AND middle = $middle and last = $last";
// Queries the database with the given variables.
if ($result = mysqli_query($con, $sql)) {

    /* fetch associative array */
    while ($row = mysqli_fetch_row($result)) {
        $row[0] = $f;
        $row[1] = $m;
        $row[2] = $l;
    }

    /* free result set */
    mysqli_free_result($result);
}



?>


<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  <div>
      <label for="first">First Name:</label>
      <input type="text" name="first">
      <label for="middle">Middle Initial:</label>
      <input type="text" name="middle">
      <label for="last">Last Name:</label>
      <input type="text" name="last">
      <input type="submit" name="punchIn" value="Punch in" />
      <input type="submit" name="punchOut" value="Punch out" />
  </div>
</form>
<?php
make_html_end();

?>
