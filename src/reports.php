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
make_html_begin(_("Select Report"), array());
make_nav_begin();
$db = conn_db();
global $db;

if (!$db)
{
    die_message(MSG_SYSTEM_ERROR, _("Error establishing database connection."), __FILE__, __LINE__);
}


require_once (SOS_PATH . 'include/global.php');
require_once (SOS_PATH . 'include/config.php');
require_once (SOS_PATH . 'functions/html.php');

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

$form_noTime = $db->real_escape_string($POST['noTime']);
$form_time = $db->real_escape_string($POST['Time']);
$form_demo = $db->real_escape_string($POST['demo']);
$query_arr = array();
global $query_count;
global $query_arr;


if (isset($POST['time_sub'])) {
	if ($form_time == "Q1") {
        if ($form_demo == "MM") {
            $query = '(SELECT COUNT(a.f_name) AS TOTAL
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_initial AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-01-01 00:00:00" AND "2020-04-01 00:00:00" AND a.gender = "Male" AND a.ethnicity = "Hispanic")';
            $result = mysqli_query($db, $query);
            while ($row = mysqli_fetch_assoc($result)) {
                $query_count = $row['TOTAL'];
                $query_arr[count] = $query_count; 
				$_SESSION['results'] = $query_arr;
            }
        } elseif ($form_demo == "MR") {
            $query = '(SELECT COUNT(a.f_name) AS TOTAL, a.race
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_initial AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-01-01 00:00:00" AND "2020-04-01 00:00:00" AND a.gender = "Male"
					GROUP BY a.race)';
            $result = mysqli_query($db, $query);
            while ($row = mysqli_fetch_assoc($result)) {
                $query_count = $row['TOTAL'];
                $query_race = $row['a.race'];
                $query_arr[count] = array($query_count);
				$query_arr[race] = array($query_race);
            }
        } elseif ($form_demo == "FM") {
            $query = '(SELECT COUNT(a.f_name) AS TOTAL
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_initial AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-01-01 00:00:00" AND "2020-04-01 00:00:00" AND a.gender = "Female" AND a.ethnicity = "Hispanic")';
            $result = mysqli_query($db, $query);
            while ($row = mysqli_fetch_assoc($result)) {
                $query_count = $row['TOTAL'];
                $query_arr[count] = array($query_count);
            }
        } elseif ($form_demo == "FR") {
            $query = '(SELECT COUNT(a.f_name) AS TOTAL, a.race
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_initial AND b.l_name = a.l_nameAND b.time_in BETWEEN "2020-01-01 00:00:00" AND "2020-04-01 00:00:00" AND a.gender = "Female"
					GROUP BY a.race)';
            $result = mysqli_query($db, $query);
          while ($row = mysqli_fetch_assoc($result)) {
                $query_count = $row['TOTAL'];
                $query_race = $row['a.race'];
                $query_arr[count] = array($query_count);
				$query_arr[race] = array($query_race);
            }
        } elseif ($form_demo == "XM") {
            $query = '(SELECT COUNT(a.f_name, a.m_initial, a.l_name)
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_initial AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-01-01 00:00:00" AND "2020-04-01 00:00:00" AND a.ethnicity = "Hispanic" AND a.gender != "Male" AND a.gender != "Female")';
            $result = mysqli_query($db, $query);
            while ($row == mysqli_fetch_assoc($result)) {
                $query_count = $row['COUNT(a.f_name, a.m_initial, a.l_name)'];
                $query_arr[] = array($query_count);
            }
        } elseif ($form_demo == "XR") {
            $query = '(SELECT COUNT(a.f_name, a.m_initial, a.l_name), a.race
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_initial AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-01-01 00:00:00" AND "2020-04-01 00:00:00" AND a.gender != "Male" AND a.gender != "Female"
					GROUP BY a.race)';
            $result = mysqli_query($db, $query);
            while ($row == mysqli_fetch_assoc($result)) {
                $query_count = $row['COUNT(a.f_name, a.m_initial, a.l_name)'];
                $query_race = $row['a.race'];
                $query_arr[] = array($query_count, $query_race);
            }
        } else {
            $query = '(SELECT COUNT(a.f_name, a.m_initial, a.l_name)
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-01-01 00:00:00" AND "2020-04-01 00:00:00")';
            $result = mysqli_query($db, $query);
            while ($row == mysqli_fetch_assoc($result)) {
                $query_count = $row['COUNT(a.f_name, a.m_initial, a.l_name)'];
                $query_arr[] = array($query_count);
            }
        }
    }
	elseif ($form_time == "Q2") {
		if ($form_demo == "MM") {
			$query = '(SELECT COUNT(a.f_name, a.m_initial, a.l_name)
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-04-01 00:00:00" AND "2020-07-01 00:00:00" AND a.gender = "Male" AND a.ethnicity = "Hispanic")';
			$result = mysqli_query($db, $query);
			while ($row == mysqli_fetch_assoc($result)) {
				$query_count = $row['COUNT(a.f_name, a.m_initial, a.l_name)'];
				$query_arr[] = array($query_count);
			}
		}
		elseif ($form_demo == "MR") {
			$query = '(SELECT COUNT(a.f_name, a.m_initial, a.l_name), a.race
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-04-01 00:00:00" AND "2020-07-01 00:00:00" AND a.gender = "Male"
					GROUP BY a.race)';
            $result = mysqli_query($db, $query);
			while ($row == mysqli_fetch_assoc($result)) {
				$query_count = $row['COUNT(a.f_name, a.m_initial, a.l_name)'];
				$query_race = $row['a.race'];
				$query_arr[] = array($query_count, $query_race);
			}
		}
		elseif ($form_demo == "FM") {
			$query = '(SELECT COUNT(a.f_name) AS TOTAL
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-04-01 00:00:00" AND "2020-07-01 00:00:00" AND a.gender = "Female" AND a.ethnicity = "Hispanic")';
			$result = mysqli_query($db, $query);
			while ($row = mysqli_fetch_assoc($result)) {
				$query_count = $row['TOTAL'];
				$query_arr[] = array($query_count);
			}
		}
		elseif ($form_demo == "FR") {
			$query = '(SELECT COUNT(a.f_name, a.m_initial, a.l_name), a.race
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-04-01 00:00:00" AND "2020-07-01 00:00:00" AND a.gender = "Female"
					GROUP BY a.race)';
            $result = mysqli_query($db, $query);
			while ($row == mysqli_fetch_assoc($result)) {
				$query_count = $row['COUNT(a.f_name, a.m_initial, a.l_name)'];
				$query_race = $row['a.race'];
				$query_arr[] = array($query_count, $query_race);
			}
		}
		elseif ($form_demo == "XM") {
			$query = '(SELECT COUNT(a.f_name, a.m_initial, a.l_name)
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-04-01 00:00:00" AND "2020-07-01 00:00:00" AND a.ethnicity = "Hispanic" AND a.gender != "Male" AND a.gender != "Female")';
			$result = mysqli_query($db, $query);
			while ($row == mysqli_fetch_assoc($result)) {
				$query_count = $row['COUNT(a.f_name, a.m_initial, a.l_name)'];
				$query_arr[] = array($query_count);
			}
		}
		elseif ($form_demo == "XR") {
			$query = '(SELECT COUNT(a.f_name, a.m_initial, a.l_name), a.race
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-04-01 00:00:00" AND "2020-07-01 00:00:00" AND a.gender != "Male" AND a.gender != "Female"
					GROUP BY a.race)';
            $result = mysqli_query($db, $query);
			while ($row == mysqli_fetch_assoc($result)) {
				$query_count = $row['COUNT(a.f_name, a.m_initial, a.l_name)'];
				$query_race = $row['a.race'];
				$query_arr[] = array($query_count, $query_race);
			}
		}
		else {
			$query = '(SELECT COUNT(a.f_name, a.m_initial, a.l_name)
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-04-01 00:00:00" AND "2020-07-01 00:00:00")';
			$result = mysqli_query($db, $query);
			while ($row == mysqli_fetch_assoc($result)) {
				$query_count = $row['COUNT(a.f_name, a.m_initial, a.l_name)'];
				$query_arr[] = array($query_count);
			}
		}
	}
	elseif ($form_time == "Q3") {
		if ($form_demo == "MM") {
			$query = '(SELECT COUNT(a.f_name, a.m_initial, a.l_name)
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-07-01 00:00:00" AND "2020-10-01 00:00:00" AND a.gender = "Male" AND a.ethnicity = "Hispanic")';
			$result = mysqli_query($db, $query);
			while ($row == mysqli_fetch_assoc($result)) {
				$query_count = $row['COUNT(a.f_name, a.m_initial, a.l_name)'];
				$query_arr[] = array($query_count);
			}
		}
		elseif ($form_demo == "MR") {
			$query = '(SELECT COUNT(a.f_name, a.m_initial, a.l_name), a.race
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-07-01 00:00:00" AND "2020-10-01 00:00:00" AND a.gender = "Male"
					GROUP BY a.race)';
            $result = mysqli_query($db, $query);
			while ($row == mysqli_fetch_assoc($result)) {
				$query_count = $row['COUNT(a.f_name, a.m_initial, a.l_name)'];
				$query_race = $row['a.race'];
				$query_arr[] = array($query_count, $query_race);
			}
		}
		elseif ($form_demo == "FM") {
			$query = '(SELECT COUNT(a.f_name, a.m_initial, a.l_name)
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-07-01 00:00:00" AND "2020-10-01 00:00:00" AND a.gender = "Female" AND a.ethnicity = "Hispanic")';
			$result = mysqli_query($db, $query);
			while ($row == mysqli_fetch_assoc($result)) {
				$query_count = $row['COUNT(a.f_name, a.m_initial, a.l_name)'];
				$query_arr[] = array($query_count);
			}
		}
		elseif ($form_demo == "FR") {
			$query = '(SELECT COUNT(a.f_name, a.m_initial, a.l_name), a.race
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-07-01 00:00:00" AND "2020-10-01 00:00:00" AND a.gender = "Female"
					GROUP BY a.race)';
            $result = mysqli_query($db, $query);
			while ($row == mysqli_fetch_assoc($result)) {
				$query_count = $row['COUNT(a.f_name, a.m_initial, a.l_name)'];
				$query_race = $row['a.race'];
				$query_arr[] = array($query_count, $query_race);
			}
		}
		elseif ($form_demo == "XM") {
			$query = '(SELECT COUNT(a.f_name, a.m_initial, a.l_name)
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-07-01 00:00:00" AND "2020-10-01 00:00:00" AND a.ethnicity = "Hispanic" AND a.gender != "Male" AND a.gender != "Female")';
			$result = mysqli_query($db, $query);
			while ($row == mysqli_fetch_assoc($result)) {
				$query_count = $row['COUNT(a.f_name, a.m_initial, a.l_name)'];
				$query_arr[] = array($query_count);
			}
		}
		elseif ($form_demo == "XR") {
			$query = '(SELECT COUNT(a.f_name, a.m_initial, a.l_name), a.race
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-07-01 00:00:00" AND "2020-10-01 00:00:00" AND a.gender != "Male" AND a.gender != "Female"
					GROUP BY a.race)';
            $result = mysqli_query($db, $query);
			while ($row == mysqli_fetch_assoc($result)) {
				$query_count = $row['COUNT(a.f_name, a.m_initial, a.l_name)'];
				$query_race = $row['a.race'];
				$query_arr[] = array($query_count, $query_race);
			}
		}
		else {
			$query = '(SELECT COUNT(a.f_name, a.m_initial, a.l_name)
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-07-01 00:00:00" AND "2020-10-01 00:00:00")';
			$result = mysqli_query($db, $query);
			while ($row == mysqli_fetch_assoc($result)) {
				$query_count = $row['COUNT(a.f_name, a.m_initial, a.l_name)'];
				$query_arr[] = array($query_count);
			}
		}
	}
	elseif ($form_time == "Q4") {
		if ($form_demo == "MM") {
			$query = '(SELECT COUNT(a.f_name, a.m_initial, a.l_name)
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-10-01 00:00:00" AND "2021-01-01 00:00:00" AND a.gender = "Male" AND a.ethnicity = "Hispanic")';
			$result = mysqli_query($db, $query);
			while ($row == mysqli_fetch_assoc($result)) {
				$query_count = $row['COUNT(a.f_name, a.m_initial, a.l_name)'];
				$query_arr[] = array($query_count);
			}
		}
		elseif ($form_demo == "MR") {
			$query = '(SELECT COUNT(a.f_name, a.m_initial, a.l_name), a.race
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-10-01 00:00:00" AND "2021-01-01 00:00:00" AND a.gender = "Male"
					GROUP BY a.race)';
            $result = mysqli_query($db, $query);
			while ($row == mysqli_fetch_assoc($result)) {
			$query_count = $row['COUNT(a.f_name, a.m_initial, a.l_name)'];
			$query_race = $row['a.race'];
			$query_arr[] = array($query_count, $query_race);
			}
		}
		elseif ($form_demo == "FM") {
			$query = '(SELECT COUNT(a.f_name, a.m_initial, a.l_name)
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-10-01 00:00:00" AND "2021-01-01 00:00:00" AND a.gender = "Female" AND a.ethnicity = "Hispanic")';
			$result = mysqli_query($db, $query);
			while ($row == mysqli_fetch_assoc($result)) {
				$query_count = $row['COUNT(a.f_name, a.m_initial, a.l_name)'];
				$query_arr[] = array($query_count);
			}
		}
		elseif ($form_demo == "FR") {
			$query = '(SELECT COUNT(a.f_name, a.m_initial, a.l_name), a.race
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-10-01 00:00:00" AND "2021-01-01 00:00:00" AND a.gender = "Female"
					GROUP BY a.race)';
            $result = mysqli_query($db, $query);
			while ($row == mysqli_fetch_assoc($result)) {
				$query_count = $row['COUNT(a.f_name, a.m_initial, a.l_name)'];
				$query_race = $row['a.race'];
				$query_arr[] = array($query_count, $query_race);
			}
		}
		elseif ($form_demo == "XM") {
			$query = '(SELECT COUNT(a.f_name, a.m_initial, a.l_name)
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-10-01 00:00:00" AND "2021-01-01 00:00:00" AND a.ethnicity = "Hispanic" AND a.gender != "Male" AND a.gender != "Female")';
			$result = mysqli_query($db, $query);
			while ($row == mysqli_fetch_assoc($result)) {
				$query_count = $row['COUNT(a.f_name, a.m_initial, a.l_name)'];
				$query_arr[] = array($query_count);
			}
		}
		elseif ($form_demo == "XR") {
			$query = '(SELECT COUNT(a.f_name, a.m_initial, a.l_name), a.race
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-10-01 00:00:00" AND "2021-01-01 00:00:00" AND a.gender != "Male" AND a.gender != "Female"
					GROUP BY a.race)';
            $result = mysqli_query($db, $query);
			while ($row == mysqli_fetch_assoc($result)) {
				$query_count = $row['COUNT(a.f_name, a.m_initial, a.l_name)'];
				$query_race = $row['a.race'];
				$query_arr[] = array($query_count, $query_race);
			}
		}
		else {
			$query = '(SELECT COUNT(a.f_name, a.m_initial, a.l_name)
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-10-01 00:00:00" AND "2021-01-01 00:00:00")';
			$result = mysqli_query($db, $query);
			while ($row == mysqli_fetch_assoc($result)) {
				$query_count = $row['COUNT(a.f_name, a.m_initial, a.l_name)'];
				$query_arr[] = array($query_count);
			}
		}
	}
	elseif ($form_time == "First") {
		if ($form_demo == "MM") {
			$query = '(SELECT COUNT(a.f_name, a.m_initial, a.l_name)
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-01-01 00:00:00" AND "2020-07-01 00:00:00" AND a.gender = "Male" AND a.ethnicity = "Hispanic")';
			$result = mysqli_query($db, $query);
			while ($row == mysqli_fetch_assoc($result)) {
				$query_count = $row['COUNT(a.f_name, a.m_initial, a.l_name)'];
				$query_arr[] = array($query_count);
			}
		}
		elseif ($form_demo == "MR") {
			$query = '(SELECT COUNT(a.f_name, a.m_initial, a.l_name), a.race
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-01-01 00:00:00" AND "2020-07-01 00:00:00" AND a.gender = "Male"
					GROUP BY a.race)';
            $result = mysqli_query($db, $query);
			while ($row == mysqli_fetch_assoc($result)) {
				$query_count = $row['COUNT(a.f_name, a.m_initial, a.l_name)'];
				$query_race = $row['a.race'];
				$query_arr[] = array($query_count, $query_race);
			}
		}
		elseif ($form_demo == "FM") {
			$query = '(SELECT COUNT(a.f_name, a.m_initial, a.l_name)
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-01-01 00:00:00" AND "2020-07-01 00:00:00" AND a.gender = "Female" AND a.ethnicity = "Hispanic")';
			$result = mysqli_query($db, $query);
			while ($row == mysqli_fetch_assoc($result)) {
				$query_count = $row['COUNT(a.f_name, a.m_initial, a.l_name)'];
				$query_arr[] = array($query_count);
			}
		}
		elseif ($form_demo == "FR") {
			$query = '(SELECT COUNT(a.f_name, a.m_initial, a.l_name), a.race
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-01-01 00:00:00" AND "2020-07-01 00:00:00" AND a.gender = "Female"
					GROUP BY a.race)';
            $result = mysqli_query($db, $query);
			while ($row == mysqli_fetch_assoc($result)) {
				$query_count = $row['COUNT(a.f_name, a.m_initial, a.l_name)'];
				$query_race = $row['a.race'];
				$query_arr[] = array($query_count, $query_race);
			}
		}
		elseif ($form_demo == "XM") {
			$query = '(SELECT COUNT(a.f_name, a.m_initial, a.l_name)
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-01-01 00:00:00" AND "2020-07-01 00:00:00" AND a.ethnicity = "Hispanic" AND a.gender != "Male" AND a.gender != "Female")';
			$result = mysqli_query($db, $query);
			while ($row == mysqli_fetch_assoc($result)) {
				$query_count = $row['COUNT(a.f_name, a.m_initial, a.l_name)'];
				$query_arr[] = array($query_count);
			}
		}
		elseif ($form_demo == "XR") {
			$query = '(SELECT COUNT(a.f_name, a.m_initial, a.l_name), a.race
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-01-01 00:00:00" AND "2020-07-01 00:00:00" AND a.gender != "Male" AND a.gender != "Female"
					GROUP BY a.race)';
            $result = mysqli_query($db, $query);
			while ($row == mysqli_fetch_assoc($result)) {
				$query_count = $row['COUNT(a.f_name, a.m_initial, a.l_name)'];
				$query_race = $row['a.race'];
				$query_arr[] = array($query_count, $query_race);
			}
		}
		else {
			$query = '(SELECT COUNT(a.f_name, a.m_initial, a.l_name)
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-01-01 00:00:00" AND "2020-07-01 00:00:00")';
			$result = mysqli_query($db, $query);
			while ($row == mysqli_fetch_assoc($result)) {
				$query_count = $row['COUNT(a.f_name, a.m_initial, a.l_name)'];
				$query_arr[] = array($query_count);
			}
		}
	}
	elseif ($form_time == "Second") {
		if ($form_demo == "MM") {
			$query = '(SELECT COUNT(a.f_name, a.m_initial, a.l_name)
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-07-01 00:00:00" AND "2021-01-01 00:00:00" AND a.gender = "Male" AND a.ethnicity = "Hispanic")';
			$result = mysqli_query($db, $query);
			while ($row == mysqli_fetch_assoc($result)) {
				$query_count = $row['COUNT(a.f_name, a.m_initial, a.l_name)'];
				$query_arr[] = array($query_count);
			}
		}
		elseif ($form_demo == "MR") {
			$query = '(SELECT COUNT(a.f_name, a.m_initial, a.l_name), a.race
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-07-01 00:00:00" AND "2021-01-01 00:00:00" AND a.gender = "Male"
					GROUP BY a.race)';
            $result = mysqli_query($db, $query);
			while ($row == mysqli_fetch_assoc($result)) {
				$query_count = $row['COUNT(a.f_name, a.m_initial, a.l_name)'];
				$query_race = $row['a.race'];
				$query_arr[] = array($query_count, $query_race);
			}
		}
		elseif ($form_demo == "FM") {
			$query = '(SELECT COUNT(a.f_name, a.m_initial, a.l_name)
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-07-01 00:00:00" AND "2021-01-01 00:00:00" AND a.gender = "Female" AND a.ethnicity = "Hispanic")';
			$result = mysqli_query($db, $query);
			while ($row == mysqli_fetch_assoc($result)) {
				$query_count = $row['COUNT(a.f_name, a.m_initial, a.l_name)'];
				$query_arr[] = array($query_count);
			}
		}
		elseif ($form_demo == "FR") {
			$query = '(SELECT COUNT(a.f_name, a.m_initial, a.l_name), a.race
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-07-01 00:00:00" AND "2021-01-01 00:00:00" AND a.gender = "Female"
					GROUP BY a.race)';
            $result = mysqli_query($db, $query);
			while ($row == mysqli_fetch_assoc($result)) {
				$query_count = $row['COUNT(a.f_name, a.m_initial, a.l_name)'];
				$query_race = $row['a.race'];
				$query_arr[] = array($query_count, $query_race);
			}
		}
		elseif ($form_demo == "XM") {
			$query = '(SELECT COUNT(a.f_name, a.m_initial, a.l_name)
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-07-01 00:00:00" AND "2021-01-01 00:00:00" AND a.ethnicity = "Hispanic" AND a.gender != "Male" AND a.gender != "Female")';
			$result = mysqli_query($db, $query);
			while ($row == mysqli_fetch_assoc($result)) {
				$query_count = $row['COUNT(a.f_name, a.m_initial, a.l_name)'];
				$query_arr[] = array($query_count);
			}
		}
		elseif ($form_demo == "XR") {
			$query = '(SELECT COUNT(a.f_name, a.m_initial, a.l_name), a.race
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-07-01 00:00:00" AND "2021-01-01 00:00:00" AND a.gender != "Male" AND a.gender != "Female"
					GROUP BY a.race)';
            $result = mysqli_query($db, $query);
			while ($row == mysqli_fetch_assoc($result)) {
				$query_count = $row['COUNT(a.f_name, a.m_initial, a.l_name)'];
				$query_race = $row['a.race'];
				$query_arr[] = array($query_count, $query_race);
			}
		}
		else {
			$query = '(SELECT COUNT(a.f_name, a.m_initial, a.l_name)
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-07-01 00:00:00" AND "2021-01-01 00:00:00")';
			$result = mysqli_query($db, $query);
			while ($row == mysqli_fetch_assoc($result)) {
				$query_count = $row['COUNT(a.f_name, a.m_initial, a.l_name)'];
				$query_arr[] = array($query_count);
			}
		}
	}
		elseif ($form_time == "Annual") {
		if ($form_demo == "MM") {
			$query = '(SELECT COUNT(a.f_name, a.m_initial, a.l_name)
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-01-01 00:00:00" AND "2021-01-01 00:00:00" AND a.gender = "Male" AND a.ethnicity = "Hispanic")';
			$result = mysqli_query($db, $query);
			while ($row == mysqli_fetch_assoc($result)) {
				$query_count = $row['COUNT(a.f_name, a.m_initial, a.l_name)'];
				$query_arr[] = array($query_count);
			}
		}
		elseif ($form_demo == "MR") {
			$query = '(SELECT COUNT(a.f_name, a.m_initial, a.l_name), a.race
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-01-01 00:00:00" AND "2021-01-01 00:00:00" AND a.gender = "Male"
					GROUP BY a.race)';
            $result = mysqli_query($db, $query);
			while ($row == mysqli_fetch_assoc($result)) {
				$query_count = $row['COUNT(a.f_name, a.m_initial, a.l_name)'];
				$query_race = $row['a.race'];
				$query_arr[] = array($query_count, $query_race);
			}
		}
		elseif ($form_demo == "FM") {
			$query = '(SELECT COUNT(a.f_name, a.m_initial, a.l_name)
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-01-01 00:00:00" AND "2021-01-01 00:00:00" AND a.gender = "Female" AND a.ethnicity = "Hispanic")';
			$result = mysqli_query($db, $query);
			while ($row == mysqli_fetch_assoc($result)) {
				$query_count = $row['COUNT(a.f_name, a.m_initial, a.l_name)'];
				$query_arr[] = array($query_count);
			}
		}
		elseif ($form_demo == "FR") {
			$query = '(SELECT COUNT(a.f_name, a.m_initial, a.l_name), a.race
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-01-01 00:00:00" AND "2021-01-01 00:00:00" AND a.gender = "Female"
					GROUP BY a.race)';
            $result = mysqli_query($db, $query);
			while ($row == mysqli_fetch_assoc($result)) {
				$query_count = $row['COUNT(a.f_name, a.m_initial, a.l_name)'];
				$query_race = $row['a.race'];
				$query_arr[] = array($query_count, $query_race);
			}
		}
		elseif ($form_demo == "XM") {
			$query = '(SELECT COUNT(a.f_name, a.m_initial, a.l_name)
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-01-01 00:00:00" AND "2021-01-01 00:00:00" AND a.ethnicity = "Hispanic" AND a.gender != "Male" AND a.gender != "Female")';
			$result = mysqli_query($db, $query);
			while ($row == mysqli_fetch_assoc($result)) {
				$query_count = $row['COUNT(a.f_name, a.m_initial, a.l_name)'];
				$query_arr[] = array($query_count);
			}
		}
		elseif ($form_demo == "XR") {
			$query = '(SELECT COUNT(a.f_name, a.m_initial, a.l_name), a.race
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-01-01 00:00:00" AND "2021-01-01 00:00:00" AND a.gender != "Male" AND a.gender != "Female"
					GROUP BY a.race)';
            $result = mysqli_query($db, $query);
			while ($row == mysqli_fetch_assoc($result)) {
				$query_count = $row['COUNT(a.f_name, a.m_initial, a.l_name)'];
				$query_race = $row['a.race'];
				$query_arr[] = array($query_count, $query_race);
			}
		}
		else {
			$query = '(SELECT COUNT(a.f_name, a.m_initial, a.l_name)
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-01-01 00:00:00" AND "2021-01-01 00:00:00")';
			$result = mysqli_query($db, $query);
			while ($row == mysqli_fetch_assoc($result)) {
				$query_count = $row['COUNT(a.f_name, a.m_initial, a.l_name)'];
				$query_arr[] = array($query_count);
			}
		}
	}
	else {
		if ($form_demo == "MM") {
			$query = '(SELECT COUNT(a.f_name, a.m_initial, a.l_name)
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND a.gender = "Male" AND a.ethnicity = "Hispanic")';
			$result = mysqli_query($db, $query);
			while ($row == mysqli_fetch_assoc($result)) {
				$query_count = $row['COUNT(a.f_name, a.m_initial, a.l_name)'];
				$query_arr[] = array($query_count);
			}
		}
		elseif ($form_demo == "MR") {
			$query = '(SELECT COUNT(a.f_name, a.m_initial, a.l_name), a.race
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND a.gender = "Male"
					GROUP BY a.race)';
            $result = mysqli_query($db, $query);
			while ($row == mysqli_fetch_assoc($result)) {
				$query_count = $row['COUNT(a.f_name, a.m_initial, a.l_name)'];
				$query_race = $row['a.race'];
				$query_arr[] = array($query_count, $query_race);
			}
		}
		elseif ($form_demo == "FM") {
			$query = '(SELECT COUNT(a.f_name, a.m_initial, a.l_name)
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND a.gender = "Female" AND a.ethnicity = "Hispanic")';
			$result = mysqli_query($db, $query);
			while ($row == mysqli_fetch_assoc($result)) {
				$query_count = $row['COUNT(a.f_name, a.m_initial, a.l_name)'];
				$query_arr[] = array($query_count);
			}
		}
		elseif ($form_demo == "FR") {
			$query = '(SELECT COUNT(a.f_name, a.m_initial, a.l_name), a.race
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND a.gender = "Female"
					GROUP BY a.race)';
            $result = mysqli_query($db, $query);
			while ($row == mysqli_fetch_assoc($result)) {
				$query_count = $row['COUNT(a.f_name, a.m_initial, a.l_name)'];
				$query_race = $row['a.race'];
				$query_arr[] = array($query_count, $query_race);
			}
		}
		elseif ($form_demo == "XM") {
			$query = '(SELECT COUNT(a.f_name, a.m_initial, a.l_name)
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND a.ethnicity = "Hispanic" AND a.gender != "Male" AND a.gender != "Female")';
			$result = mysqli_query($db, $query);
			while ($row == mysqli_fetch_assoc($result)) {
				$query_count = $row['COUNT(a.f_name, a.m_initial, a.l_name)'];
				$query_arr[] = array($query_count);
			}
		}
		elseif ($form_demo == "XR") {
			$query = '(SELECT COUNT(a.f_name, a.m_initial, a.l_name), a.race
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND a.gender != "Male" AND a.gender != "Female"
					GROUP BY a.race)';
            $result = mysqli_query($db, $query);
			while ($row == mysqli_fetch_assoc($result)) {
				$query_count = $row['COUNT(a.f_name, a.m_initial, a.l_name)'];
				$query_race = $row['a.race'];
				$query_arr[] = array($query_count, $query_race);
			}
		}
		else {
			$query = '(SELECT COUNT(a.f_name, a.m_initial, a.l_name)
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name)';
			$result = mysqli_query($db, $query);
			while ($row == mysqli_fetch_assoc($result)) {
				$query_count = $row['COUNT(a.f_name, a.m_initial, a.l_name)'];
				$query_arr[] = array($query_count);
			}
		}
	}
}

if (isset($POST['not_time_sub'])) {
	if ($form_noTime == 'eachVol') {
		$query = '(SELECT COUNT(a.f_name, a.m_initial, a.l_name)
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_initial AND b.l_name=a.l_name)';
        $result = mysqli_query($db, $query);
		while ($row == mysqli_fetch_assoc($result)) {
				$query_count = $row['COUNT(a.f_name, a.m_initial, a.l_name)'];
				$query_arr[] = array($query_count);
		}
	}
	elseif ($form_noTime == 'Newsletter') {
    ?>
    <table border='1' style='border-collapse:collapse;'>
        <tr>
            <th>Number of Hispanic Male Volunteers</th>
        </tr>
        <?php
        $querry = '(SELECT f_name, m_initial, l_name, email_address
                        FROM VOLUNTEER
                        WHERE e_newsletter = TRUE)';
        $result = mysqli_querry($con,$querry);

        $query_arr[] = array();

        while ($row = mysqli_fetch_assoc($result)) {
        $first_name = $row['f_name'];
        $middle_i = $row['m_initial'];
        $last_name = $row['l_name'];
        $email_addr = $row['email_address'];
        $query_arr[] = array($first_name, $middle_i, $last_name, $email_addr);
        ?>
        <tr>
            <td><?php echo $first_name; ?></td>
            <td><?php echo $middle_i; ?> </td>
            <td><?php echo $last_name; ?> </td>
            <td><?php echo $email_addr; ?> </td>
        </tr>
        <?php
        }
        ?>
    </table>
    <?php
        $serialize_query_arr = serialize($query_array);
    ?>

    <textarea name='query_result_data' style='display:'> <?php echo $serialize_query_arr; ?> </textarea> <?php
	}
	else {
		$query = '(SELECT a.f_name, a.m_initial, a.l_name, SUM(b.time_worked), a.required_hours
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_initial AND b.l_name=a.l_name AND a.required_hours IS NOT NULL)';
        $result = mysqli_query($db, $query);
		while ($row == mysqli_fetch_assoc($result)) {
				$query_first = $row['a.f_name'];
				$query_middle = $row['a.m_initial'];
				$query_last = $row['a.l_name'];
				$query_sum_time = $row['SUM(b.time_worked)'];
				$query_req_hours = $row['a.required_hours'];
				$query_arr[] = array($query_first, $query_middle, $query_last, $query_sum_time, $query_req_hours);
		}
	}
}
?>
<form method ="post" action="http://ec2-54-237-6-145.compute-1.amazonaws.com/src/results.php">
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
    <option value="eachVol">Total Number of Volunteers</option>
    <option value="Newsletter">Newsletter</option>
    <option value="comServ">Community Service</option>
   </select>
   <input type="submit" name="not_time_sub" value="Submit for Not Time">
</form>
<br><br><br><br><br>
   ---------------------------------------------------------------------------------------
<br><br><br>
<?php
	$serialize_query_arr = serialize($query_arr);
?>
<textarea name='query_result_data'> <?php echo $query_count; ?>></textarea>

<?php
make_html_end();

?>
