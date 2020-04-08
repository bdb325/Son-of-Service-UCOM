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


require_once(SOS_PATH.'include/global.php');
require_once(SOS_PATH.'functions/html.php');
require_once(SOS_PATH.'functions/forminput.php');
require_once(SOS_PATH.'functions/textwriter.php');

is_logged_in();

if (array_key_exists('download', $_REQUEST))
{
    ob_start();
}
else
{
    make_html_begin(_("Reports"), array());

    make_nav_begin();
}

$db = connect_db();

if (!$db)
{
    die_message(MSG_SYSTEM_ERROR, _("Error establishing database connection."), __FILE__, __LINE__);    
}


require_once (SOS_PATH . 'include/global.php');
require_once (SOS_PATH . 'include/config.php');
require_once (SOS_PATH . 'functions/html.php');


make_html_begin(_("Select Report"), array());

$db = conn_db();

//commented out to test
// Create connection
$db = new mysqli($servername, $username, $password, $db);


// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

$form_noTime = $db->real_escape_string($POST['noTime']);
$form_time = $db->real_escape_string($POST['Time']);
$form_demo = $db->real_escape_string($POST['demo']);

if (isset($POST['time_sub'])) {
	if ($form_time == "Q1") {
		if ($form_demo == "MM") {
			$sql = 'SELECT COUNT(a.f_name, a.m_initial, a.l_name)
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-01-01 00:00:00" AND "2020-04-01 00:00:00" AND a.gender = "Male" AND a.ethnicity = "Hispanic"';
		}
		elseif ($form_demo == "MR") {
			$sql = 'SELECT COUNT(a.f_name, a.m_initial, a.l_name), a.race
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-01-01 00:00:00" AND "2020-04-01 00:00:00" AND a.gender = "Male"
					GROUP BY a.race';
		}
		elseif ($form_demo == "FM") {
			$sql = 'SELECT COUNT(a.f_name, a.m_initial, a.l_name)
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-01-01 00:00:00" AND "2020-04-01 00:00:00" AND a.gender = "Female" AND a.ethnicity = "Hispanic"';
		}
		elseif ($form_demo == "FR") {
			$sql = 'SELECT COUNT(a.f_name, a.m_initial, a.l_name), a.race
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_nameAND b.time_in BETWEEN "2020-01-01 00:00:00" AND "2020-04-01 00:00:00" AND a.gender = "Female"
					GROUP BY a.race';
		}
		elseif ($form_demo == "XM") {
			$sql = 'SELECT COUNT(a.f_name, a.m_initial, a.l_name)
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-01-01 00:00:00" AND "2020-04-01 00:00:00" AND a.ethnicity = "Hispanic" AND a.gender != "Male" AND a.gender != "Female"';
		}
		elseif ($form_demo == "XR") {
			$sql = 'SELECT COUNT(a.f_name, a.m_initial, a.l_name), a.race
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-01-01 00:00:00" AND "2020-04-01 00:00:00" AND a.gender != "Male" AND a.gender != "Female"
					GROUP BY a.race';
		}
		else {
			$sql = 'SELECT COUNT(a.f_name, a.m_initial, a.l_name)
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-01-01 00:00:00" AND "2020-04-01 00:00:00"';
		}
	}
	elseif ($form_time == "Q2") {
		if ($form_demo == "MM") {
			$sql = 'SELECT COUNT(a.f_name, a.m_initial, a.l_name)
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-04-01 00:00:00" AND "2020-07-01 00:00:00" AND a.gender = "Male" AND a.ethnicity = "Hispanic"';
		}
		elseif ($form_demo == "MR") {
			$sql = 'SELECT COUNT(a.f_name, a.m_initial, a.l_name), a.race
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-04-01 00:00:00" AND "2020-07-01 00:00:00" AND a.gender = "Male"
					GROUP BY a.race';
		}
		elseif ($form_demo == "FM") {
			$sql = 'SELECT COUNT(a.f_name, a.m_initial, a.l_name)
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-04-01 00:00:00" AND "2020-07-01 00:00:00" AND a.gender = "Female" AND a.ethnicity = "Hispanic"';
		}
		elseif ($form_demo == "FR") {
			$sql = 'SELECT COUNT(a.f_name, a.m_initial, a.l_name), a.race
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-04-01 00:00:00" AND "2020-07-01 00:00:00" AND a.gender = "Female"
					GROUP BY a.race';
		}
		elseif ($form_demo == "XM") {
			$sql = 'SELECT COUNT(a.f_name, a.m_initial, a.l_name)
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-04-01 00:00:00" AND "2020-07-01 00:00:00" AND a.ethnicity = "Hispanic" AND a.gender != "Male" AND a.gender != "Female"';
		}
		elseif ($form_demo == "XR") {
			$sql = 'SELECT COUNT(a.f_name, a.m_initial, a.l_name), a.race
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-04-01 00:00:00" AND "2020-07-01 00:00:00" AND a.gender != "Male" AND a.gender != "Female"
					GROUP BY a.race';
		}
		else {
			$sql = 'SELECT COUNT(a.f_name, a.m_initial, a.l_name)
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-04-01 00:00:00" AND "2020-07-01 00:00:00"';
		}
	}
	elseif ($form_time == "Q3") {
		if ($form_demo == "MM") {
			$sql = 'SELECT COUNT(a.f_name, a.m_initial, a.l_name)
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-07-01 00:00:00" AND "2020-10-01 00:00:00" AND a.gender = "Male" AND a.ethnicity = "Hispanic"';
		}
		elseif ($form_demo == "MR") {
			$sql = 'SELECT COUNT(a.f_name, a.m_initial, a.l_name), a.race
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-07-01 00:00:00" AND "2020-10-01 00:00:00" AND a.gender = "Male"
					GROUP BY a.race';
		}
		elseif ($form_demo == "FM") {
			$sql = 'SELECT COUNT(a.f_name, a.m_initial, a.l_name)
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-07-01 00:00:00" AND "2020-10-01 00:00:00" AND a.gender = "Female" AND a.ethnicity = "Hispanic"';
		}
		elseif ($form_demo == "FR") {
			$sql = 'SELECT COUNT(a.f_name, a.m_initial, a.l_name), a.race
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-07-01 00:00:00" AND "2020-10-01 00:00:00" AND a.gender = "Female"
					GROUP BY a.race';
		}
		elseif ($form_demo == "XM") {
			$sql = 'SELECT COUNT(a.f_name, a.m_initial, a.l_name)
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-07-01 00:00:00" AND "2020-10-01 00:00:00" AND a.ethnicity = "Hispanic" AND a.gender != "Male" AND a.gender != "Female"';
		}
		elseif ($form_demo == "XR") {
			$sql = 'SELECT COUNT(a.f_name, a.m_initial, a.l_name), a.race
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-07-01 00:00:00" AND "2020-10-01 00:00:00" AND a.gender != "Male" AND a.gender != "Female"
					GROUP BY a.race';
		}
		else {
			$sql = 'SELECT COUNT(a.f_name, a.m_initial, a.l_name)
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-07-01 00:00:00" AND "2020-10-01 00:00:00"';
		}
	}
	elseif ($form_time == "Q4") {
		if ($form_demo == "MM") {
			$sql = 'SELECT COUNT(a.f_name, a.m_initial, a.l_name)
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-10-01 00:00:00" AND "2021-01-01 00:00:00" AND a.gender = "Male" AND a.ethnicity = "Hispanic"';
		}
		elseif ($form_demo == "MR") {
			$sql = 'SELECT COUNT(a.f_name, a.m_initial, a.l_name), a.race
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-10-01 00:00:00" AND "2021-01-01 00:00:00" AND a.gender = "Male"
					GROUP BY a.race';
		}
		elseif ($form_demo == "FM") {
			$sql = 'SELECT COUNT(a.f_name, a.m_initial, a.l_name)
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-10-01 00:00:00" AND "2021-01-01 00:00:00" AND a.gender = "Female" AND a.ethnicity = "Hispanic"';
		}
		elseif ($form_demo == "FR") {
			$sql = 'SELECT COUNT(a.f_name, a.m_initial, a.l_name), a.race
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-10-01 00:00:00" AND "2021-01-01 00:00:00" AND a.gender = "Female"
					GROUP BY a.race';
		}
		elseif ($form_demo == "XM") {
			$sql = 'SELECT COUNT(a.f_name, a.m_initial, a.l_name)
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-10-01 00:00:00" AND "2021-01-01 00:00:00" AND a.ethnicity = "Hispanic" AND a.gender != "Male" AND a.gender != "Female"';
		}
		elseif ($form_demo == "XR") {
			$sql = 'SELECT COUNT(a.f_name, a.m_initial, a.l_name), a.race
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-10-01 00:00:00" AND "2021-01-01 00:00:00" AND a.gender != "Male" AND a.gender != "Female"
					GROUP BY a.race';
		}
		else {
			$sql = 'SELECT COUNT(a.f_name, a.m_initial, a.l_name)
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-10-01 00:00:00" AND "2021-01-01 00:00:00"';
		}
	}
	elseif ($form_time == "First") {
		if ($form_demo == "MM") {
			$sql = 'SELECT COUNT(a.f_name, a.m_initial, a.l_name)
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-01-01 00:00:00" AND "2020-07-01 00:00:00" AND a.gender = "Male" AND a.ethnicity = "Hispanic"';
		}
		elseif ($form_demo == "MR") {
			$sql = 'SELECT COUNT(a.f_name, a.m_initial, a.l_name), a.race
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-01-01 00:00:00" AND "2020-07-01 00:00:00" AND a.gender = "Male"
					GROUP BY a.race';
		}
		elseif ($form_demo == "FM") {
			$sql = 'SELECT COUNT(a.f_name, a.m_initial, a.l_name)
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-01-01 00:00:00" AND "2020-07-01 00:00:00" AND a.gender = "Female" AND a.ethnicity = "Hispanic"';
		}
		elseif ($form_demo == "FR") {
			$sql = 'SELECT COUNT(a.f_name, a.m_initial, a.l_name), a.race
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-01-01 00:00:00" AND "2020-07-01 00:00:00" AND a.gender = "Female"
					GROUP BY a.race';
		}
		elseif ($form_demo == "XM") {
			$sql = 'SELECT COUNT(a.f_name, a.m_initial, a.l_name)
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-01-01 00:00:00" AND "2020-07-01 00:00:00" AND a.ethnicity = "Hispanic" AND a.gender != "Male" AND a.gender != "Female"';
		}
		elseif ($form_demo == "XR") {
			$sql = 'SELECT COUNT(a.f_name, a.m_initial, a.l_name), a.race
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-01-01 00:00:00" AND "2020-07-01 00:00:00" AND a.gender != "Male" AND a.gender != "Female"
					GROUP BY a.race';
		}
		else {
			$sql = 'SELECT COUNT(a.f_name, a.m_initial, a.l_name)
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-01-01 00:00:00" AND "2020-07-01 00:00:00"';
		}
	}
	elseif ($form_time == "Second") {
		if ($form_demo == "MM") {
			$sql = 'SELECT COUNT(a.f_name, a.m_initial, a.l_name)
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-07-01 00:00:00" AND "2021-01-01 00:00:00" AND a.gender = "Male" AND a.ethnicity = "Hispanic"';
		}
		elseif ($form_demo == "MR") {
			$sql = 'SELECT COUNT(a.f_name, a.m_initial, a.l_name), a.race
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-07-01 00:00:00" AND "2021-01-01 00:00:00" AND a.gender = "Male"
					GROUP BY a.race';
		}
		elseif ($form_demo == "FM") {
			$sql = 'SELECT COUNT(a.f_name, a.m_initial, a.l_name)
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-07-01 00:00:00" AND "2021-01-01 00:00:00" AND a.gender = "Female" AND a.ethnicity = "Hispanic"';
		}
		elseif ($form_demo == "FR") {
			$sql = 'SELECT COUNT(a.f_name, a.m_initial, a.l_name), a.race
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-07-01 00:00:00" AND "2021-01-01 00:00:00" AND a.gender = "Female"
					GROUP BY a.race';
		}
		elseif ($form_demo == "XM") {
			$sql = 'SELECT COUNT(a.f_name, a.m_initial, a.l_name)
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-07-01 00:00:00" AND "2021-01-01 00:00:00" AND a.ethnicity = "Hispanic" AND a.gender != "Male" AND a.gender != "Female"';
		}
		elseif ($form_demo == "XR") {
			$sql = 'SELECT COUNT(a.f_name, a.m_initial, a.l_name), a.race
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-07-01 00:00:00" AND "2021-01-01 00:00:00" AND a.gender != "Male" AND a.gender != "Female"
					GROUP BY a.race';
		}
		else {
			$sql = 'SELECT COUNT(a.f_name, a.m_initial, a.l_name)
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-07-01 00:00:00" AND "2021-01-01 00:00:00"';
		}
	}

		elseif ($form_time == "Annual") {
		if ($form_demo == "MM") {
			$sql = 'SELECT COUNT(a.f_name, a.m_initial, a.l_name)
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-01-01 00:00:00" AND "2021-01-01 00:00:00" AND a.gender = "Male" AND a.ethnicity = "Hispanic"';
		}
		elseif ($form_demo == "MR") {
			$sql = 'SELECT COUNT(a.f_name, a.m_initial, a.l_name), a.race
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-01-01 00:00:00" AND "2021-01-01 00:00:00" AND a.gender = "Male"
					GROUP BY a.race';
		}
		elseif ($form_demo == "FM") {
			$sql = 'SELECT COUNT(a.f_name, a.m_initial, a.l_name)
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-01-01 00:00:00" AND "2021-01-01 00:00:00" AND a.gender = "Female" AND a.ethnicity = "Hispanic"';
		}
		elseif ($form_demo == "FR") {
			$sql = 'SELECT COUNT(a.f_name, a.m_initial, a.l_name), a.race
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-01-01 00:00:00" AND "2021-01-01 00:00:00" AND a.gender = "Female"
					GROUP BY a.race';
		}
		elseif ($form_demo == "XM") {
			$sql = 'SELECT COUNT(a.f_name, a.m_initial, a.l_name)
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-01-01 00:00:00" AND "2021-01-01 00:00:00" AND a.ethnicity = "Hispanic" AND a.gender != "Male" AND a.gender != "Female"';
		}
		elseif ($form_demo == "XR") {
			$sql = 'SELECT COUNT(a.f_name, a.m_initial, a.l_name), a.race
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-01-01 00:00:00" AND "2021-01-01 00:00:00" AND a.gender != "Male" AND a.gender != "Female"
					GROUP BY a.race';
		}
		else {
			$sql = 'SELECT COUNT(a.f_name, a.m_initial, a.l_name)
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-01-01 00:00:00" AND "2021-01-01 00:00:00"';
		}
	}
	else {
		if ($form_demo == "MM") {
			$sql = 'SELECT COUNT(a.f_name, a.m_initial, a.l_name)
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND a.gender = "Male" AND a.ethnicity = "Hispanic"';
		}
		elseif ($form_demo == "MR") {
			$sql = 'SELECT COUNT(a.f_name, a.m_initial, a.l_name), a.race
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND a.gender = "Male"
					GROUP BY a.race';
		}
		elseif ($form_demo == "FM") {
			$sql = 'SELECT COUNT(a.f_name, a.m_initial, a.l_name)
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND a.gender = "Female" AND a.ethnicity = "Hispanic"';
		}
		elseif ($form_demo == "FR") {
			$sql = 'SELECT COUNT(a.f_name, a.m_initial, a.l_name), a.race
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND a.gender = "Female"
					GROUP BY a.race';
		}
		elseif ($form_demo == "XM") {
			$sql = 'SELECT COUNT(a.f_name, a.m_initial, a.l_name)
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND a.ethnicity = "Hispanic" AND a.gender != "Male" AND a.gender != "Female"';
		}
		elseif ($form_demo == "XR") {
			$sql = 'SELECT COUNT(a.f_name, a.m_initial, a.l_name), a.race
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND a.gender != "Male" AND a.gender != "Female"
					GROUP BY a.race';
		}
		else {
			$sql = 'SELECT COUNT(a.f_name, a.m_initial, a.l_name)
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name';
		}
	}
}

?>
<form method ="post" action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?><!--enter url-->
	<label for="time">Time Period:</label>
  <select id="Time">
    <option value="Q1">Q1</option>
    <option value="Q2">Q2</option>
    <option value="Q3">Q3</option>
    <option value="Q4">Q4</option>
    <option value="First">First half of the year</option>
    <option value="Second">Second half of the year</option>
    <option value="Annual">Annual</option>
    <option value="None">N/A</option>
  </select> <br>
    <label for="demo">Demographics:</label>
  <select id="demo">
    <option value="MM">Male - Hispanic</option>
    <option value="MR">Male - Racial Demographics</option>
    <option value="FM">Female - Hispanic</option>
    <option value="FR">Female - Racial Demographics</option>
	<option value="XM">Non-Binary - Hispanic</option>
	<option value="XR">Non-Binary - Racial Demographics</option>
    <option value="Total">Total Volunteers in the Time Period</option>
   </select>
   <input type="submit" name="time_sub" value="Submit for Demographics">
   <br><br>
   ---------------------------------------------------------------------------------------<br><br>
   	<label for="noTime">Not Time Related:</label>
  <select id="noTime">
	<option value="blank">  </option>
    <option value="eachVol">Total Number of Volunteers</option>
    <option value="Newsletter">Newsletter</option>
    <option value="comServ">Community Service</option>
   </select>
   <input type="submit" name="not_time_sub" value="Submit for Not Time">
</form>


<?php
make_html_end();

?>
