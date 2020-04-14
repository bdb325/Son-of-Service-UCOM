<?php

/*
 * Son of Service
 * Copyright (C) 2003-2009 by Andrew Ziem.  All rights reserved.
 * Licensed under the GNU General Public License.  See COPYING for details.
 *
 * Updated and repurposed by Grand Valley Soluitons - Winter 2020 IS Capstone Group.
 *
 * $Id: add_VOLUNTEER.php,v 1.19 2009/02/13 03:52:15 andrewziem Exp $
 *
 */

ob_start();
session_start();

define('SOS_PATH', '../');


require_once(SOS_PATH.'include/global.php');
require_once(SOS_PATH.'functions/html.php');
require_once(SOS_PATH.'functions/forminput.php');
require_once(SOS_PATH.'functions/textwriter.php');

is_logged_in();
make_html_begin(_("Report"), array());
make_nav_begin();
$db = conn_db();
global $db;

require_once (SOS_PATH . 'include/global.php');
require_once (SOS_PATH . 'include/config.php');
require_once (SOS_PATH . 'functions/html.php');

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

$sql = '(SELECT COUNT(a.f_name) AS TOTAL, a.race AS RACE
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_initial AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-01-01 00:00:00" AND "2020-04-01 00:00:00" AND a.gender = "Male")';
$result = $db->query($sql);
echo "<table border='1'>";
echo "<tr><td>First</td><td>Middle</td><td>Last</td><td>Email</td></tr>";
while ($row = $result->fetch_assoc()) {
  echo "<tr><td>{$row['TOTAL']}</td><td>{$row['RACE']}</td></tr>\n";
}
echo "</table>";
make_html_end();
