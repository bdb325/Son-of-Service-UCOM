<?php
/*
 * Son of Service
 * Copyright (C) 2003-2009 by Andrew Ziem.  All rights reserved.
 * Licensed under the GNU General Public License.  See COPYING for details.
 *
 * Updated and repurposed by Grand Valley Soluitons - Winter 2020 IS Capstone Group.
 *
 *
 * $Id: welcome.php,v 1.23 2009/02/12 04:11:20 andrewziem Exp $
 *
 */

session_start();
ob_start();

define('SOS_PATH', '../');
require_once (SOS_PATH . 'include/global.php');
require_once (SOS_PATH . 'functions/html.php');
require_once (SOS_PATH . 'functions/table.php');
make_html_begin(_("Admin functions"), array());
make_nav_begin();
$db = conn_db();

global $db;

if(!$db) {
die("Connection failed: " . $db->connect_error);
}

is_logged_in();
/* Accesses Array Elements */
function results() {
  return $varArray;
}



/* Displays Volunteer Info for updating after seaching. Variables are passed in to display search results. */
function updateVolunteerForm($var1,$var2,$var3,$var4,$var5,$var6,$var7,$var8,$var9,$var10,$var11,$var12,$var13,$var14,$var15,$var16,$var17,$var18,$var19,$var20) {

?>
<form method ="post" action="http://ec2-54-237-6-145.compute-1.amazonaws.com/src/admin.php">
  <div id="update">
    <label for="firstna">First Name:</label>
    <input type="text" name="firstna" value="<?= $var1 ?>" >
    <label for="minit">Middle Initial:</label>
    <input type="text" name="minit" value="<?= $var2 ?>" >
    <label for="lastna">Last Name:</label>
    <input type="text" name="lastna" value="<?= $var3 ?>" >
    <label for="race">Race:</label>
    <input type="text" name="race" value="<?= $var4 ?>" >
    <label for="ethnicity">Ethnicity:</label>
    <input type="text" name="ethnicity"value="<?= $var5 ?>" >
    <label for="gender">Gender:</label>
    <input type="text" name="gender" value="<?= $var6 ?>" >
    <label for="veteran_status">Veteran Status:</label>
    <input type="text" name="veteran_status" value="<?= $var7 ?>" >
    <label for="volunteer_type">Volunteer area:</label>
    <input type="text" name="volunteer_type" value="<?= $var8 ?>" >
    <label for="birth_date">Birth Date:</label>
    <input type="text" name="birth_date" value="<?= $var9 ?>" >
    <label for="email_address">Email Address:</label>
    <input type="text" name="email_address" value="<?= $var10 ?>" >
    <label for="phone_number">Phone Number:</label>
    <input type="text" name="phone_number" value="<?= $var11 ?>" >
    <label for="country">Country:</label>
    <input type="text" name="country" value="<?= $var12 ?>" >
    <label for="street_address">Address:</label>
    <input type="text" name="street_address" value="<?= $var13 ?>" >
    <label for="state_providence">State:</label>
    <input type="text" name="state_providence" value="<?= $var14 ?>" >
    <label for="city">City:</label>
    <input type="text" name="city" value="<?= $var15 ?>" >
    <label for="postal_code">Zip Code:</label>
    <input type="text" name="postal_code" value="<?= $var16 ?>" >
    <label for="emergency_fName">Emergency Contact First:</label>
    <input type="text" name="emergency_fName" value="<?= $var17 ?>" >
    <label for="emergency_lName">Emergency Last:</label>
    <input type="text" name="emergency_lName" value="<?= $var18 ?>" >
    <label for="emergency_phone">Emergency Phone:</label>
    <input type="text" name="emergency_phone" value="<?= $var19 ?>" >
    <label for="emergency_relationship">Relationship of emergency contact:</label>
    <input type="text" name="emergency_relationship" value="<?= $var20 ?>" >
    <input type="submit" name="update" value="Update volunteer info" />
  </div>
</form>
<?php

}

function updateHoursForm($first, $middle, $last,$time_in,$time_out,$time_worked,$punch) {
  ?>
    <form method ="post" action="http://ec2-54-237-6-145.compute-1.amazonaws.com/src/admin.php">
      <div id="hours">
        <label for="fnameH">First name:</label>
        <input type="text" name="fnameH" value="<?= $first ?>">
        <label for="minitH">Middle initial:</label>
        <input type="text" name="minitH" value="<?= $middle ?>">
        <label for="lnameH">Last name:</label>
        <input type="text" name="lnameH" value="<?= $last ?>">
        <label for="time_in">Time in:</label>
        <input type="text" name="time_in" value="<?= $time_in ?>">
        <label for="time_out">Time out:</label>
        <input type="text" name="time_out" value="<?= $time_out ?>">
        <label for="time_worked">Time worked:</label>
        <input type="text" name="time_worked" value="<?= $time_worked ?>">
        <label for="autopunch">Auto punch out flag:</label>
        <input type="text" name="autopunch" value="<?= $punch ?>">
        <input type="submit" name="hours" value="Update hours table"/>
      </div>
    </form>
  <?php
}

if (isset($_POST['delete'])) {

  $first = $db->real_escape_string($_POST['first']);
  $emailDelete = $db->real_escape_string($_POST['emailDelete']);
  $last = $db->real_escape_string($_POST['last']);
  $sql = "DELETE VOLUNTEER from VOLUNTEER WHERE VOLUNTEER.f_name = ? AND VOLUNTEER.email_address = ? AND VOLUNTEER.l_name = ?";
  if($stmt = $db->prepare($sql)) {
    $stmt->bind_param("sss", $first, $emailDelete, $last);
    $stmt->execute();
    $row = $stmt->affected_rows;
    if ($row > 0) {
      echo "Deleted Volunteer Successfully!";
    }
    elseif ($row < 1) {
    echo "No volunteers found matching your criteria. Please try again.";
  }
  else {
      echo "Error : " . $stmt . "<br>" . $sql->error;
  }
  }
  
}
if (isset($_POST['searchUpdate'])) {
  global $var1,$var2,$var3,$var4,$var5,$var6,$var7,$var8,$var9,$var10,$var11,$var12,$var13,$var14,$var15,$var16;
  $first = $db->real_escape_string($_POST['firstn']);
  $last = $db->real_escape_string($_POST['lastn']);
  $email = $db->real_escape_string($_POST['email']);
  $sql = "SELECT * FROM VOLUNTEER WHERE VOLUNTEER.f_name = ? AND VOLUNTEER.l_name = ? AND VOLUNTEER.email_address = ?";
  $stmt = $db->prepare($sql);
  $stmt->bind_param("sss", $first, $last, $email);
  $stmt->execute();
  $data = $stmt->get_result();
  while ($dataset = $data->fetch_assoc()) {
  $_SESSION["first"] =  $var1 = $dataset['f_name'];
  $_SESSION["middle"] = $var2 = $dataset['m_initial'];
  $_SESSION["last"] = $var3 = $dataset['l_name'];
    $var4 = $dataset['race'];
    $var5 = $dataset['ethnicity'];
    $var6 = $dataset['gender'];
    $var7 = $dataset['veteran_status'];
    $var8 = $dataset['volunteer_type'];
    $var9 = $dataset['birth_date'];
    $var10 = $dataset['email_address'];
    $var11 = $dataset['phone_number'];
    $var12 = $dataset['country'];
    $var13 = $dataset['street_address'];
    $var14 = $dataset['state_providence'];
    $var15 = $dataset['city'];
    $var16 = $dataset['postal_code'];
    $var17 = $dataset['emergency_fName'];
    $var18 = $dataset['emergency_lName'];
    $var19 = $dataset['emergency_phone'];
    $var20 = $dataset['emergency_relationship'];
   }
  updateVolunteerForm($var1,$var2,$var3,$var4,$var5,$var6,$var7,$var8,$var9,$var10,$var11,$var12,$var13,$var14,$var15,$var16,$var17,$var18,$var19,$var20);
}
  if (isset($_POST['update'])) {
  global $db;
      $first = ($_POST['firstna']);
      $indexFirst = $db->real_escape_string($_POST['firstna']);
      $middle = $db->real_escape_string($_POST['minit']);
      $last = $db->real_escape_string($_POST['lastna']);
      $indexLast = $db->real_escape_string($_POST['lastna']);
      $race = $db->real_escape_string($_POST['race']);
      $ethnicity = $db->real_escape_string($_POST['ethnicity']);
      $gender = $db->real_escape_string($_POST['gender']);
      $veteran_status = $db->real_escape_string($_POST['veteran_status']);
      $volunteer_type = $db->real_escape_string($_POST['volunteer_type']);
      $birth_date = $db->real_escape_string($_POST['birth_date']);
      $email_address = $db->real_escape_string($_POST['email_address']);
      $indexEmail = $db->real_escape_string($_POST['email_address']);
      $phone_number = $db->real_escape_string($_POST['phone_number']);
      $country = $db->real_escape_string($_POST['country']);
      $street_address = $db->real_escape_string($_POST['street_address']);
      $state = $db->real_escape_string($_POST['state_providence']);
      $city = $db->real_escape_string($_POST['city']);
      $postal = $db->real_escape_string($_POST['postal_code']);
      $emergency_fname = $db->real_escape_string($_POST['emergency_fName']);
      $emergency_lname = $db->real_escape_string($_POST['emergency_lName']);
      $emergency_phone = $db->real_escape_string($_POST['emergency_phone']);
      $emergency_relationship = $db->real_escape_string($_POST['emergency_relationship']);
      $sql = "UPDATE VOLUNTEER SET f_name = '$first', m_initial = '$middle', l_name = '$last', race = '$race',
      ethnicity = '$ethnicity', gender = '$gender' , veteran_status = '$veteran_status', volunteer_type = '$volunteer_type', birth_date = '$birth_date', email_address = '$email_address',
      phone_number = '$phone_number', country = '$country', street_address = '$street_address', state_providence = '$state', city = '$city', postal_code = '$postal',
     emergency_fName = '$emergency_fname', emergency_lName = '$emergency_lname', emergency_phone = '$emergency_phone', emergency_relationship = '$emergency_relationship' WHERE f_name = '$indexFirst'
      AND l_name = '$indexLast' AND email_address = '$indexEmail'";
      //19 values are prepared
      if ($db->query($sql) === TRUE)
      {
        echo "Updated information successfully. Re-directing in 5 seconds";
        header('Refresh: 5; URL=http://ec2-54-237-6-145.compute-1.amazonaws.com/src/admin.php');
     }
      else {
          echo "Update unable to execute.";
         }
 }

 if (isset($_POST['searchHours'])) {
   $first = $db->real_escape_string($_POST['firstname']);
   $last = $db->real_escape_string($_POST['lastname']);
   $middle = $db->real_escape_string($_POST['middleinitial']);
   $sql = "SELECT * FROM HOURS WHERE f_name = ? AND m_initial = ? AND l_name = ?";
   $stmt = $db->prepare($sql);
   $stmt->bind_param("sss", $first, $middle, $last);
   $stmt->execute();
   $data = $stmt->get_result();
   while ($dataset = $data->fetch_assoc()) {
     $var1 = $dataset['f_name'];
     $var2 = $dataset['m_initial'];
     $var3 = $dataset['l_name'];
     $var4 = $dataset['time_in'];
     $var5 = $dataset['time_out'];
     $var6 = $dataset['time_worked'];
     $var7 = $dataset['auto_punch_out_flag'];
   }
  updateHoursForm($var1,$var2,$var3,$var4,$var5,$var6,$var7);
}

if (isset($_POST['hours'])) {
  $first = $db->real_escape_string($_POST['fnameH']);
  $middle = $db->real_escape_string($_POST['minitH']);
  $last = $db->real_escape_string($_POST['lnameH']);
  $time_in = $db->real_escape_string($_POST['time_in']);
  $time_out = $db->real_escape_string($_POST['time_out']);
  $time_worked = $db->real_escape_string($_POST['time_worked']);
  $punch = $db->real_escape_string($_POST['autopunch']);
  $sql = "UPDATE HOURS SET time_in = '$time_in', time_out = '$time_out', time_worked = '$time_worked', auto_punch_out_flag = '$punch' WHERE f_name = '$first' AND m_initial = '$middle' AND l_name = '$last'";
  if ($db->query($sql) === TRUE)
  {
    echo "Updated information successfully. Re-directing in 5 seconds";
    header('Refresh: 5; URL=http://ec2-54-237-6-145.compute-1.amazonaws.com/src/admin.php');
 }
  else {
      echo ("Try again.");
       updateHoursForm($var1,$var2,$var3,$var4,$var5,$var6,$var7);
     }


}





?>
<form method="post" action="http://ec2-54-237-6-145.compute-1.amazonaws.com/src/admin.php">
  <div id="delete">
    <h1> Delete Volunteer </h1>
    <label for="first">First Name:</label>
    <input type="text" name="first">
    <label for="last">Last Name:</label>
    <input type="text" name="last">
    <label for="emailDelete">Email Address:</label>
    <input type="text" name="emailDelete">
    <input type="submit" name="delete" value="Delete Volunteer" />
  </div>
</form>
<form method="post" action ="http://ec2-54-237-6-145.compute-1.amazonaws.com/src/admin.php">
  <div id="searchUpdate">
    <h1> Update Volunteer Information </h1>
    <p> Search a Volunteer to update their information. </p>
    <label for="firstn">First Name:</label>
    <input type="text" name="firstn">
    <label for="lastn">Last Name:</label>
    <input type="text" name="lastn">
    <label for="email">Email Address:</label>
    <input type="text" name="email">
    <input type="submit" name="searchUpdate" value="Update volunteer table information"/>
  </div>
</form>
<form method="post" action ="http://ec2-54-237-6-145.compute-1.amazonaws.com/src/admin.php">
  <div id="searchHours">
    <h1> Update Hour Information </h1>
    <p> Search a Volunteer to update their hours worked. </p>
    <label for="firstname">First Name:</label>
    <input type="text" name="firstname">
    <label for="middleinitial">Middle Initial:</label>
    <input type="text" name="middleinitial">
    <label for="lastname">Last Name:</label>
    <input type="text" name="lastname">
    <input type="submit" name="searchHours" value="Update hour table information"/>
  </div>
</form>





<?php

make_html_end();
?>
