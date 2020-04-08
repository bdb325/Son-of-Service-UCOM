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

require_once(SOS_PATH . 'include/config.php');
require_once(SOS_PATH . 'include/global.php');
require_once(SOS_PATH . 'functions/html.php');
require_once(SOS_PATH . 'functions/access.php');
require_once(SOS_PATH . 'functions/db.php');

$db = conn_db();

if (!$db)
{
    die_message(MSG_SYSTEM_ERROR, _("Error establishing database connection."), __FILE__, __LINE__);
}

is_logged_in();

make_html_begin("Welcome", array());

make_nav_begin();


$result = $db->query("SELECT * FROM HOURS WHERE auto_punch_out_flag = 1");


echo ("Volunteers who need to be punched out" . "<br>");
while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
  echo $row['f_name'] . " " . $row['l_name'];
}




make_html_end();

?>
