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

if(!$db) {
die("Connection failed: " . $db->connect_error);
}

if (isset($_POST['delete'])) {
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
?>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
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

<?php

make_html_end();
?>
