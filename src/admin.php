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

global $varArray;
$var1 = $varArray['f_name'];
$var2;
$var3;
$var4;
$var5;
$var6;
$var7;
$var8;
$var9;
$var10;
$var11;
$var12;
$var13;
$var14;
$var15;
$varArray = array();


if(!$db) {
die("Connection failed: " . $db->connect_error);
}

/* Accesses Array Elements */
function results() {
  return $varArray;
}



/* Displays Volunteer Info for updating after seaching. I'm so sorry I passed in 15 variables :/ */
function updateVolunteerForm($var1,$var2,$var3,$var4,$var5,$var6,$var7,$var8,$var9,$var10,$var11,$var12,$var13,$var14,$var15) {

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
    <input type="text" name="email_address" value="<?= $var9 ?>" >
    <label for="phone_number">Phone Number:</label>
    <input type="text" name="phone_number" value="<?= $var10 ?>" >
    <label for="country">Country:</label>
    <input type="text" name="country" value="<?= $var11 ?>" >
    <label for="street_address">Address:</label>
    <input type="text" name="street_address" value="<?= $var12 ?>" >
    <label for="state_providence">State:</label>
    <input type="text" name="state_providence" value="<?= $var13 ?>" >
    <label for="city">City:</label>
    <input type="text" name="city" value="<?= $var14 ?>" >
    <label for="postal_code">Zip Code:</label>
    <input type="text" name="postal_code" value="<?= $var15 ?>" >
    <input type="submit" name="update" value="Update Volunteer Info" />
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
  global $var1,$var2,$var3,$var4,$var5,$var6,$var7,$var8,$var9,$var10,$var11,$var12,$var13,$var14,$var15,$varArray;
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
    $var2 = $dataset[1];
    $var3 = $dataset[2];
    $var4 = $dataset[3];
    $var5 = $dataset[4];
    $var6 = $dataset[5];
    $var7 = $dataset[6];
    $var8 = $dataset[7];
    $var9 = $dataset[8];
    $var10 = $dataset[9];
    $var11 = $dataset[10];
    $var12 = $dataset[11];
    $var13 = $dataset[12];
    $var14 = $dataset[13];
    $var15 = $dataset[14];
}
  print_r($dataset);
  updateVolunteerForm($var1,$var2,$var3,$var4,$var5,$var6,$var7,$var8,$var9,$var10,$var11,$var12,$var13,$var14,$var15);



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
