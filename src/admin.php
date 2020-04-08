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
    <input type="text" name="firstna" placeholder="<?= $var1 ?>" >
    <label for="minit">Middle Initial:</label>
    <input type="text" name="minit" placeholder="<?= $var2 ?>" >
    <label for="lastna">Last Name:</label>
    <input type="text" name="lastna" placeholder="<?= $var3 ?>" >
    <label for="race">Race:</label>
    <input type="text" name="race" placeholder="<?= $var4 ?>" >
    <label for="ethnicity">Ethnicity:</label>
    <input type="text" name="ethnicity"placeholder="<?= $var5 ?>" >
    <label for="gender">Gender:</label>
    <input type="text" name="gender" placeholder="<?= $var6 ?>" >
    <label for="veteran_status">Veteran Status:</label>
    <input type="text" name="veteran_status" placeholder="<?= $var7 ?>" >
    <label for="volunteer_type">Volunteer area:</label>
    <input type="text" name="volunteer_type" placeholder="<?= $var8 ?>" >
    <label for="birth_date">Birth Date:</label>
    <input type="text" name="birth_date" placeholder="<?= $var9 ?>" >
    <label for="email_address">Email Address:</label>
    <input type="text" name="email_address" placeholder="<?= $var10 ?>" >
    <label for="phone_number">Phone Number:</label>
    <input type="text" name="phone_number" placeholder="<?= $var11 ?>" >
    <label for="country">Country:</label>
    <input type="text" name="country" placeholder="<?= $var12 ?>" >
    <label for="street_address">Address:</label>
    <input type="text" name="street_address" placeholder="<?= $var13 ?>" >
    <label for="state_providence">State:</label>
    <input type="text" name="state_providence" placeholder="<?= $var14 ?>" >
    <label for="city">City:</label>
    <input type="text" name="city" placeholder="<?= $var15 ?>" >
    <label for="postal_code">Zip Code:</label>
    <input type="text" name="postal_code" placeholder="<?= $var16 ?>" >
    <label for="emergency_fName">Emergency Contact First:</label>
    <input type="text" name="emergency_fName" placeholder="<?= $var17 ?>" >
    <label for="emergency_lName">Emergency Last:</label>
    <input type="text" name="emergency_lName" placeholder="<?= $var18 ?>" >
    <label for="emergency_phone">Emergency Phone:</label>
    <input type="text" name="emergency_phone" placeholder="<?= $var19 ?>" >
    <label for="emergency_relationship">Relationship of emergency contact:</label>
    <input type="text" name="emergency_relationship" placeholder="<?= $var20 ?>" >
    <input type="submit" name="update" value="Update volunteer info" />
  </div>
</form>


<?php

}

if (isset($_POST['delete'])) {

  $first = $db->real_escape_string($_POST['first']);
  $middle = $db->real_escape_string($_POST['middle']);
  $last = $db->real_escape_string($_POST['last']);
  $sql = "DELETE VOLUNTEER from VOLUNTEER WHERE VOLUNTEER.f_name = ? AND VOLUNTEER.m_initial = ? AND VOLUNTEER.l_name = ?";
  if($stmt = $db->prepare($sql)) {
    $stmt->bind_param("sss", $first, $middle, $last);
    $stmt->execute();
    $row = $db->affected_rows;
    if ($row > 0) {
      echo "Deleted Volunteer Successfully!";
    }
  }
  else {
    echo "Error : " . $stmt . "<br>" . $sql->error;
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
    $var1 = $dataset['f_name'];
    $var2 = $dataset['m_initial'];
    $var3 = $dataset['l_name'];
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
  if (isset($_POST['update'])) {
  /*  $stmt = $db->prepare($sql); */
  global $db;
      $first = $db->real_escape_string($_POST['firstna']);
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
      ethnicity = '$ethnicity', gender = '$gender' , veteran_status = '$veteran_status', birth_date = '$birth_date', email_address = '$email_address',
      phone_number = '$phone_number', country = '$country', street_address = '$street_address', state_providence = '$state', city = '$city', postal_code = '$postal',
     emergency_fName = '$emergency_fname', emergency_lName = '$emergency_lname', emergency_phone = '$emergency_phone', emergency_relationship = '$emergency_relationship' WHERE f_name = '$indexFirst'
      AND l_name = '$indexLast' AND email_address = '$indexEmail'";
      //19 values are prepared
    /*  $stmt->bind_param("ssssssssssdssssssssssss", $first, $middle, $last, $race, $ethnicity, $gender, $veteran_status, $volunteer_type, $birth_date,
    $emaiL_address, $phone_number, $country, $street_address, $state, $city, $postal, $emergency_fname, $emergency_lname,
  $emergency_phone, $emergency_relationship, $indexFirst, $indexLast, $indexEmail); */
      if ($db->query($sql) === TRUE)
      {
        echo "Updated information successfully. Re-directing in 5 seconds";
        header('Refresh: 5; URL=http://ec2-54-237-6-145.compute-1.amazonaws.com/src/admin.php');
     }
      else {
           // BLAINE FOR SOME REASON UPDATE ISNT WORKING FUCKING FIX IT DOG.
           echo "It failed :("
         }

    /* else {
     echo $sql;
     echo $stmt;
     echo "Error : " . $stmt . $db->error;
   }
   */

 }
  }



?>
<form method="post" action="http://ec2-54-237-6-145.compute-1.amazonaws.com/src/admin.php">
  <div id="delete">
    <h1> Delete Volunter </h1>
    <label for="first">First Name:</label>
    <input type="text" name="first">
    <label for="middle">Middle Initial:</label>
    <input type="text" name="middle">
    <label for="last">Last Name:</label>
    <input type="text" name="last">
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
    <input type="submit" name="searchUpdate" value="Search for a volunteer"/>
  </div>
</form>

<?php

make_html_end();
?>
