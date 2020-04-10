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

$sql = "SELECT * FROM VOLUNTEER WHERE e_newsletter = TRUE";

$result = $db->query($sql);

while ($row = $result->fetch_assoc()) {
  echo ($row['f_name']);
  echo ($row['m_initial']);
  echo ($row['l_name']);
  echo ($row['email_address'] <br/>);



}
make_html_end();
