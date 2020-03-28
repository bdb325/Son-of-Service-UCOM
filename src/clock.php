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
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}
// note need to add two php codes. clock in and clock out
$first = $con->real_escape_string($_POST['first']);
$middle =$con->real_escape_string($_POST['middle']);
$last = $con->real_escape_string($_POST['last']);
function addQuotes($str){
    return "'$str'";
}


if (isset($_POST['punchIn'])) {
      #Punch in was clicked
              $sql = "INSERT INTO HOURS (f_name,m_initial,l_name,time_in)
              SELECT v.f_name, v.m_initial, v.l_name, now()
              FROM VOLUNTEER v
              WHERE v.f_name = ? AND v.m_initial = ? AND v.l_name = ? ";
              if ($stmt = $con->prepare($sql)) {
              $stmt->bind_param("sss", $first, $middle, $last);
              $stmt->execute();
            }
/*
              if ($con->query($sql) === TRUE) {
                  echo "Punched in successfully!";
                  }
                  else {
                    echo "Error : " . $sql . "<br>" . $con->error;
                      }
          }
*/

}

  //Although unconventional, this second option is using a different way of coding for testing purposes.
elseif (isset($_POST['punchOut'])) {



  $sql = "UPDATE HOURS
  SET time_out=now()
  WHERE  f_name = ?  AND m_initial = ? AND l_name = ?";
  $stmt = $con->prepare($sql);
  $stmt->bind_param("sss", $first, $middle, $last);
  $stmt->execute();
/*
  if ($stmt->execute() === TRUE) {
      echo "Punched out successfully";
  } else {
      echo "Error: " . $sql . "<br>" . $stmt->error;
  */

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
