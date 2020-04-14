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
// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}



require_once (SOS_PATH . 'include/global.php');
require_once (SOS_PATH . 'include/config.php');
require_once (SOS_PATH . 'functions/html.php');



$query_arr = array();
global $query_count;
global $query_arr;


if (isset($_POST['time_sub'])) {
	$form_noTime = $_POST['noTime'];
	$form_time = $_POST['Time'];
	$form_demo = $_POST['demo'];
	if ($form_time == "Q1") {
        if ($form_demo == "MM") {
            $sql = '(SELECT COUNT(a.f_name) AS TOTAL
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_initial AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-01-01 00:00:00" AND "2020-04-01 00:00:00" AND a.gender = "Male" AND a.ethnicity = "Hispanic")';
			$result = $db->query($sql);
			echo "<table border='1'>";
			echo "<tr><td>Total Number of Q1 Male - Hispanic Volunteers</td></tr>";
			while ($row = $result->fetch_assoc()) {
			  echo "<tr><td>{$row['TOTAL']}</td></tr>\n";
			}
			echo "</table>";
        } elseif ($form_demo == "MR") {
            $sql = '(SELECT COUNT(a.f_name) AS TOTAL, a.race AS RACE
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_initial AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-01-01 00:00:00" AND "2020-04-01 00:00:00" AND a.gender = "Male"
					GROUP BY a.race)';
            $result = $db->query($sql);
			echo "<table border='1'>";
			echo "<tr><td>Racial Breakdown of Q1 Male Volunteers</td></tr>";
			while ($row = $result->fetch_assoc()) {
			  echo "<tr><td>{$row['TOTAL']}</td><td>{$row['RACE']}</td></tr>\n";
			}
			echo "</table>";
        } elseif ($form_demo == "FM") {
            $sql = '(SELECT COUNT(a.f_name) AS TOTAL
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_initial AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-01-01 00:00:00" AND "2020-04-01 00:00:00" AND a.gender = "Female" AND a.ethnicity = "Hispanic")';
            $result = $db->query($sql);
			echo "<table border='1'>";
			echo "<tr><td>Total Number of Q1 Female - Hispanic Volunteers</td></tr>";
			while ($row = $result->fetch_assoc()) {
			  echo "<tr><td>{$row['TOTAL']}</td></tr>\n";
			}
			echo "</table>";
        } elseif ($form_demo == "FR") {
            $sql = '(SELECT COUNT(a.f_name) AS TOTAL, a.race AS RACE
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_initial AND b.l_name = a.l_nameAND b.time_in BETWEEN "2020-01-01 00:00:00" AND "2020-04-01 00:00:00" AND a.gender = "Female"
					GROUP BY a.race)';
            $result = $db->query($sql);
			echo "<table border='1'>";
			echo "<tr><td>Racial Breakdown of Q1 Female Volunteers</td></tr>";
			while ($row = $result->fetch_assoc()) {
			  echo "<tr><td>{$row['TOTAL']}</td><td>{$row['RACE']}</td></tr>\n";
			}
			echo "</table>";
        } elseif ($form_demo == "XM") {
            $sql = '(SELECT COUNT(a.f_name) AS TOTAL
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_initial AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-01-01 00:00:00" AND "2020-04-01 00:00:00" AND a.ethnicity = "Hispanic" AND a.gender != "Male" AND a.gender != "Female")';
            $result = $db->query($sql);
			echo "<table border='1'>";
			echo "<tr><td>Total Number of Q1 Non-Binary - Hispanic Volunteers</td></tr>";
			while ($row = $result->fetch_assoc()) {
			  echo "<tr><td>{$row['TOTAL']}</td></tr>\n";
			}
			echo "</table>";
        } elseif ($form_demo == "XR") {
            $sql = '(SELECT COUNT(a.f_name) AS TOTAL, a.race AS RACE
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_initial AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-01-01 00:00:00" AND "2020-04-01 00:00:00" AND a.gender != "Male" AND a.gender != "Female"
					GROUP BY a.race)';
            $result = $db->query($sql);
			echo "<table border='1'>";
			echo "<tr><td>Racial Breakdown of Q1 Non-Binary Volunteers</td></tr>";
			while ($row = $result->fetch_assoc()) {
			  echo "<tr><td>{$row['TOTAL']}</td><td>{$row['RACE']}</td></tr>\n";
			}
			echo "</table>";
        } else {
            $sql = '(SELECT COUNT(a.f_name) as TOTAL
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-01-01 00:00:00" AND "2020-04-01 00:00:00")';
            $result = $db->query($sql);
			echo "<table border='1'>";
			echo "<tr><td>Total Number of Q1 Volunteers</td></tr>";
			while ($row = $result->fetch_assoc()) {
			  echo "<tr><td>{$row['TOTAL']}</td></tr>\n";
			}
			echo "</table>";
        }
    }
	elseif ($form_time == "Q2") {
		if ($form_demo == "MM") {
			$sql = '(SELECT COUNT(a.f_name) AS TOTAL
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-04-01 00:00:00" AND "2020-07-01 00:00:00" AND a.gender = "Male" AND a.ethnicity = "Hispanic")';
			$result = $db->query($sql);
			echo "<table border='1'>";
			echo "<tr><td>Total Number of Q2 Male - Hispanic Volunteers</td></tr>";
			while ($row = $result->fetch_assoc()) {
			  echo "<tr><td>{$row['TOTAL']}</td></tr>\n";
			}
			echo "</table>";
		}
		elseif ($form_demo == "MR") {
			$sql = '(SELECT COUNT(a.f_name) AS TOTAL, a.race AS RACE
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-04-01 00:00:00" AND "2020-07-01 00:00:00" AND a.gender = "Male"
					GROUP BY a.race)';
            $result = $db->query($sql);
			echo "<table border='1'>";
			echo "<tr><td>Racial Breakdown of Q2 Male Volunteers</td></tr>";
			while ($row = $result->fetch_assoc()) {
			  echo "<tr><td>{$row['TOTAL']}</td><td>{$row['RACE']}</td></tr>\n";
			}
			echo "</table>";
		}
		elseif ($form_demo == "FM") {
			$sql = '(SELECT COUNT(a.f_name) AS TOTAL
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-04-01 00:00:00" AND "2020-07-01 00:00:00" AND a.gender = "Female" AND a.ethnicity = "Hispanic")';
			$result = $db->query($sql);
			echo "<table border='1'>";
			echo "<tr><td>Total Number of Q2 Female - Hispanic Volunteers</td></tr>";
			while ($row = $result->fetch_assoc()) {
			  echo "<tr><td>{$row['TOTAL']}</td></tr>\n";
			}
			echo "</table>";
		}
		elseif ($form_demo == "FR") {
			$sql = '(SELECT COUNT(a.f_name) AS TOTAL, a.race AS RACE
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-04-01 00:00:00" AND "2020-07-01 00:00:00" AND a.gender = "Female"
					GROUP BY a.race)';
            $result = $db->query($sql);
			echo "<table border='1'>";
			echo "<tr><td>Racial Breakdown of Q2 Female Volunteers</td></tr>";
			while ($row = $result->fetch_assoc()) {
			  echo "<tr><td>{$row['TOTAL']}</td><td>{$row['RACE']}</td></tr>\n";
			}
			echo "</table>";
		}
		elseif ($form_demo == "XM") {
			$sql = '(SELECT COUNT(a.f_name) AS TOTAL
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-04-01 00:00:00" AND "2020-07-01 00:00:00" AND a.ethnicity = "Hispanic" AND a.gender != "Male" AND a.gender != "Female")';
			$result = $db->query($sql);
			echo "<table border='1'>";
			echo "<tr><td>Total Number of Q2 Non-Binary - Hispanic Volunteers</td></tr>";
			while ($row = $result->fetch_assoc()) {
			  echo "<tr><td>{$row['TOTAL']}</td></tr>\n";
			}
			echo "</table>";
		}
		elseif ($form_demo == "XR") {
			$sql = '(SELECT COUNT(a.f_name) AS TOTAL, a.race AS RACE
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-04-01 00:00:00" AND "2020-07-01 00:00:00" AND a.gender != "Male" AND a.gender != "Female"
					GROUP BY a.race)';
            $result = $db->query($sql);
			echo "<table border='1'>";
			echo "<tr><td>Racial Breakdown of Q2 Non-Binary Volunteers</td></tr>";
			while ($row = $result->fetch_assoc()) {
			  echo "<tr><td>{$row['TOTAL']}</td><td>{$row['RACE']}</td></tr>\n";
			}
			echo "</table>";
		}
		else {
			$sql = '(SELECT COUNT(a.f_name) AS TOTAL
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-04-01 00:00:00" AND "2020-07-01 00:00:00")';
			$result = $db->query($sql);
			echo "<table border='1'>";
			echo "<tr><td>Total Number of Q2 Volunteers</td></tr>";
			while ($row = $result->fetch_assoc()) {
			  echo "<tr><td>{$row['TOTAL']}</td></tr>\n";
			}
			echo "</table>";
		}
	}
	elseif ($form_time == "Q3") {
		if ($form_demo == "MM") {
			$sql = '(SELECT COUNT(a.f_name) AS TOTAL
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-07-01 00:00:00" AND "2020-10-01 00:00:00" AND a.gender = "Male" AND a.ethnicity = "Hispanic")';
			$result = $db->query($sql);
			echo "<table border='1'>";
			echo "<tr><td>Total Number of Q3 Male - Hispanic Volunteers</td></tr>";
			while ($row = $result->fetch_assoc()) {
			  echo "<tr><td>{$row['TOTAL']}</td></tr>\n";
			}
			echo "</table>";
		}
		elseif ($form_demo == "MR") {
			$sql = '(SELECT COUNT(a.f_name) AS TOTAL, a.race AS RACE
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-07-01 00:00:00" AND "2020-10-01 00:00:00" AND a.gender = "Male"
					GROUP BY a.race)';
            $result = $db->query($sql);
			echo "<table border='1'>";
			echo "<tr><td>Racial Breakdown of Q3 Male Volunteers</td></tr>";
			while ($row = $result->fetch_assoc()) {
			  echo "<tr><td>{$row['TOTAL']}</td><td>{$row['RACE']}</td></tr>\n";
			}
			echo "</table>";
		}
		elseif ($form_demo == "FM") {
			$sql = '(SELECT COUNT(a.f_name) AS TOTAL
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-07-01 00:00:00" AND "2020-10-01 00:00:00" AND a.gender = "Female" AND a.ethnicity = "Hispanic")';
			$result = $db->query($sql);
			echo "<table border='1'>";
			echo "<tr><td>Total Number of Q3 Female - Hispanic Volunteers</td></tr>";
			while ($row = $result->fetch_assoc()) {
			  echo "<tr><td>{$row['TOTAL']}</td></tr>\n";
			}
			echo "</table>";
		}
		elseif ($form_demo == "FR") {
			$sql = '(SELECT COUNT(a.f_name) AS TOTAL, a.race AS RACE
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-07-01 00:00:00" AND "2020-10-01 00:00:00" AND a.gender = "Female"
					GROUP BY a.race)';
            $result = $db->query($sql);
			echo "<table border='1'>";
			echo "<tr><td>Racial Breakdown of Q3 Female Volunteers</td></tr>";
			while ($row = $result->fetch_assoc()) {
			  echo "<tr><td>{$row['TOTAL']}</td><td>{$row['RACE']}</td></tr>\n";
			}
			echo "</table>";
		}
		elseif ($form_demo == "XM") {
			$sql = '(SELECT COUNT(a.f_name) AS TOTAL
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-07-01 00:00:00" AND "2020-10-01 00:00:00" AND a.ethnicity = "Hispanic" AND a.gender != "Male" AND a.gender != "Female")';
			$result = $db->query($sql);
			echo "<table border='1'>";
			echo "<tr><td>Total Number of Q3 Non-Binary - Hispanic Volunteers</td></tr>";
			while ($row = $result->fetch_assoc()) {
			  echo "<tr><td>{$row['TOTAL']}</td></tr>\n";
			}
			echo "</table>";
		}
		elseif ($form_demo == "XR") {
			$sql = '(SELECT COUNT(a.f_name) AS TOTAL, a.race AS RACE
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-07-01 00:00:00" AND "2020-10-01 00:00:00" AND a.gender != "Male" AND a.gender != "Female"
					GROUP BY a.race)';
            $result = $db->query($sql);
			echo "<table border='1'>";
			echo "<tr><td>Racial Breakdown of Q3 Non-Binary Volunteers</td></tr>";
			while ($row = $result->fetch_assoc()) {
			  echo "<tr><td>{$row['TOTAL']}</td><td>{$row['RACE']}</td></tr>\n";
			}
			echo "</table>";
		}
		else {
			$sql = '(SELECT COUNT(a.f_name) AS TOTAL
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-07-01 00:00:00" AND "2020-10-01 00:00:00")';
			$result = $db->query($sql);
			echo "<table border='1'>";
			echo "<tr><td>Total Number of Q3 Volunteers</td></tr>";
			while ($row = $result->fetch_assoc()) {
			  echo "<tr><td>{$row['TOTAL']}</td></tr>\n";
			}
			echo "</table>";
		}
	}
	elseif ($form_time == "Q4") {
		if ($form_demo == "MM") {
			$sql = '(SELECT COUNT(a.f_name) AS TOTAL
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-10-01 00:00:00" AND "2021-01-01 00:00:00" AND a.gender = "Male" AND a.ethnicity = "Hispanic")';
			$result = $db->query($sql);
			echo "<table border='1'>";
			echo "<tr><td>Total Number of Q4 Male - Hispanic Volunteers</td></tr>";
			while ($row = $result->fetch_assoc()) {
			  echo "<tr><td>{$row['TOTAL']}</td></tr>\n";
			}
			echo "</table>";
		}
		elseif ($form_demo == "MR") {
			$sql = '(SELECT COUNT(a.f_name) AS TOTAL, a.race AS RACE
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-10-01 00:00:00" AND "2021-01-01 00:00:00" AND a.gender = "Male"
					GROUP BY a.race)';
            $result = $db->query($sql);
			echo "<table border='1'>";
			echo "<tr><td>Racial Breakdown of Q4 Male Volunteers</td></tr>";
			while ($row = $result->fetch_assoc()) {
			  echo "<tr><td>{$row['TOTAL']}</td><td>{$row['RACE']}</td></tr>\n";
			}
			echo "</table>";
		}
		elseif ($form_demo == "FM") {
			$sql = '(SELECT COUNT(a.f_name) AS TOTAL
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-10-01 00:00:00" AND "2021-01-01 00:00:00" AND a.gender = "Female" AND a.ethnicity = "Hispanic")';
			$result = $db->query($sql);
			echo "<table border='1'>";
			echo "<tr><td>Total Number of Q4 Female - Hispanic Volunteers</td></tr>";
			while ($row = $result->fetch_assoc()) {
			  echo "<tr><td>{$row['TOTAL']}</td></tr>\n";
			}
			echo "</table>";
		}
		elseif ($form_demo == "FR") {
			$sql = '(SELECT COUNT(a.f_name) AS TOTAL, a.race AS RACE
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-10-01 00:00:00" AND "2021-01-01 00:00:00" AND a.gender = "Female"
					GROUP BY a.race)';
            $result = $db->query($sql);
			echo "<table border='1'>";
			echo "<tr><td>Racial Breakdown of Q4 Female Volunteers</td></tr>";
			while ($row = $result->fetch_assoc()) {
			  echo "<tr><td>{$row['TOTAL']}</td><td>{$row['RACE']}</td></tr>\n";
			}
			echo "</table>";
		}
		elseif ($form_demo == "XM") {
			$sql = '(SELECT COUNT(a.f_name) AS TOTAL
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-10-01 00:00:00" AND "2021-01-01 00:00:00" AND a.ethnicity = "Hispanic" AND a.gender != "Male" AND a.gender != "Female")';
			$result = $db->query($sql);
			echo "<table border='1'>";
			echo "<tr><td>Total Number of Q4 Non-Binary - Hispanic Volunteers</td></tr>";
			while ($row = $result->fetch_assoc()) {
			  echo "<tr><td>{$row['TOTAL']}</td></tr>\n";
			}
			echo "</table>";
		}
		elseif ($form_demo == "XR") {
			$sql = '(SELECT COUNT(a.f_name) AS TOTAL, a.race AS RACE
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-10-01 00:00:00" AND "2021-01-01 00:00:00" AND a.gender != "Male" AND a.gender != "Female"
					GROUP BY a.race)';
            $result = $db->query($sql);
			echo "<table border='1'>";
			echo "<tr><td>Racial Breakdown of Q4 Non-Binary Volunteers</td></tr>";
			while ($row = $result->fetch_assoc()) {
			  echo "<tr><td>{$row['TOTAL']}</td><td>{$row['RACE']}</td></tr>\n";
			}
			echo "</table>";
		}
		else {
			$sql = '(SELECT COUNT(a.f_name) AS TOTAL
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-10-01 00:00:00" AND "2021-01-01 00:00:00")';
			$result = $db->query($sql);
			echo "<table border='1'>";
			echo "<tr><td>Total Number of Q4 Volunteers</td></tr>";
			while ($row = $result->fetch_assoc()) {
			  echo "<tr><td>{$row['TOTAL']}</td></tr>\n";
			}
			echo "</table>";
		}
	}
	elseif ($form_time == "First") {
		if ($form_demo == "MM") {
			$sql = '(SELECT COUNT(a.f_name) AS TOTAL
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-01-01 00:00:00" AND "2020-07-01 00:00:00" AND a.gender = "Male" AND a.ethnicity = "Hispanic")';
			$result = $db->query($sql);
			echo "<table border='1'>";
			echo "<tr><td>Total Number of 1st Half Male - Hispanic Volunteers</td></tr>";
			while ($row = $result->fetch_assoc()) {
			  echo "<tr><td>{$row['TOTAL']}</td></tr>\n";
			}
			echo "</table>";
		}
		elseif ($form_demo == "MR") {
			$sql = '(SELECT COUNT(a.f_name) AS TOTAL, a.race AS RACE
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-01-01 00:00:00" AND "2020-07-01 00:00:00" AND a.gender = "Male"
					GROUP BY a.race)';
            $result = $db->query($sql);
			echo "<table border='1'>";
			echo "<tr><td>Racial Breakdown of 1st Half Male Volunteers</td></tr>";
			while ($row = $result->fetch_assoc()) {
			  echo "<tr><td>{$row['TOTAL']}</td><td>{$row['RACE']}</td></tr>\n";
			}
			echo "</table>";
		}
		elseif ($form_demo == "FM") {
			$sql = '(SELECT COUNT(a.f_name) AS TOTAL
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-01-01 00:00:00" AND "2020-07-01 00:00:00" AND a.gender = "Female" AND a.ethnicity = "Hispanic")';
			$result = $db->query($sql);
			echo "<table border='1'>";
			echo "<tr><td>Total Number of 1st Half Female - Hispanic Volunteers</td></tr>";
			while ($row = $result->fetch_assoc()) {
			  echo "<tr><td>{$row['TOTAL']}</td></tr>\n";
			}
			echo "</table>";
		}
		elseif ($form_demo == "FR") {
			$sql = '(SELECT COUNT(a.f_name) AS TOTAL, a.race AS RACE
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-01-01 00:00:00" AND "2020-07-01 00:00:00" AND a.gender = "Female"
					GROUP BY a.race)';
            $result = $db->query($sql);
			echo "<table border='1'>";
			echo "<tr><td>Racial Breakdown of 1st Half Female Volunteers</td></tr>";
			while ($row = $result->fetch_assoc()) {
			  echo "<tr><td>{$row['TOTAL']}</td><td>{$row['RACE']}</td></tr>\n";
			}
			echo "</table>";
		}
		elseif ($form_demo == "XM") {
			$sql = '(SELECT COUNT(a.f_name) AS TOTAL
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-01-01 00:00:00" AND "2020-07-01 00:00:00" AND a.ethnicity = "Hispanic" AND a.gender != "Male" AND a.gender != "Female")';
			$result = $db->query($sql);
			echo "<table border='1'>";
			echo "<tr><td>Total Number of 1st Half Non-Binary - Hispanic Volunteers</td></tr>";
			while ($row = $result->fetch_assoc()) {
			  echo "<tr><td>{$row['TOTAL']}</td></tr>\n";
			}
			echo "</table>";
		}
		elseif ($form_demo == "XR") {
			$sql = '(SELECT COUNT(a.f_name) AS TOTAL, a.race AS RACE
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-01-01 00:00:00" AND "2020-07-01 00:00:00" AND a.gender != "Male" AND a.gender != "Female"
					GROUP BY a.race)';
            $result = $db->query($sql);
			echo "<table border='1'>";
			echo "<tr><td>Racial Breakdown of 1st Half Non-Binary Volunteers</td></tr>";
			while ($row = $result->fetch_assoc()) {
			  echo "<tr><td>{$row['TOTAL']}</td><td>{$row['RACE']}</td></tr>\n";
			}
			echo "</table>";
		}
		else {
			$sql = '(SELECT COUNT(a.f_name) AS TOTAL
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-01-01 00:00:00" AND "2020-07-01 00:00:00")';
			$result = $db->query($sql);
			echo "<table border='1'>";
			echo "<tr><td>Total Number of 1st Half Volunteers</td></tr>";
			while ($row = $result->fetch_assoc()) {
			  echo "<tr><td>{$row['TOTAL']}</td></tr>\n";
			}
			echo "</table>";
		}
	}
	elseif ($form_time == "Second") {
		if ($form_demo == "MM") {
			$sql = '(SELECT COUNT(a.f_name) AS TOTAL
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-07-01 00:00:00" AND "2021-01-01 00:00:00" AND a.gender = "Male" AND a.ethnicity = "Hispanic")';
			$result = $db->query($sql);
			echo "<table border='1'>";
			echo "<tr><td>Total Number of 2nd Half Male - Hispanic Volunteers</td></tr>";
			while ($row = $result->fetch_assoc()) {
			  echo "<tr><td>{$row['TOTAL']}</td></tr>\n";
			}
			echo "</table>";
		}
		elseif ($form_demo == "MR") {
			$sql = '(SELECT COUNT(a.f_name) AS TOTAL, a.race AS RACE
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-07-01 00:00:00" AND "2021-01-01 00:00:00" AND a.gender = "Male"
					GROUP BY a.race)';
            $result = $db->query($sql);
			echo "<table border='1'>";
			echo "<tr><td>Racial Breakdown of 2nd Half Male Volunteers</td></tr>";
			while ($row = $result->fetch_assoc()) {
			  echo "<tr><td>{$row['TOTAL']}</td><td>{$row['RACE']}</td></tr>\n";
			}
			echo "</table>";
		}
		elseif ($form_demo == "FM") {
			$sql = '(SELECT COUNT(a.f_name) AS TOTAL
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-07-01 00:00:00" AND "2021-01-01 00:00:00" AND a.gender = "Female" AND a.ethnicity = "Hispanic")';
			$result = $db->query($sql);
			echo "<table border='1'>";
			echo "<tr><td>Total Number of 2nd Half Female - Hispanic Volunteers</td></tr>";
			while ($row = $result->fetch_assoc()) {
			  echo "<tr><td>{$row['TOTAL']}</td></tr>\n";
			}
			echo "</table>";
		}
		elseif ($form_demo == "FR") {
			$sql = '(SELECT COUNT(a.f_name) AS TOTAL, a.race AS RACE
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-07-01 00:00:00" AND "2021-01-01 00:00:00" AND a.gender = "Female"
					GROUP BY a.race)';
           $result = $db->query($sql);
			echo "<table border='1'>";
			echo "<tr><td>Racial Breakdown of 2nd Half Female Volunteers</td></tr>";
			while ($row = $result->fetch_assoc()) {
			  echo "<tr><td>{$row['TOTAL']}</td><td>{$row['RACE']}</td></tr>\n";
			}
			echo "</table>";
		}
		elseif ($form_demo == "XM") {
			$sql = '(SELECT COUNT(a.f_name) AS TOTAL
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-07-01 00:00:00" AND "2021-01-01 00:00:00" AND a.ethnicity = "Hispanic" AND a.gender != "Male" AND a.gender != "Female")';
			$result = $db->query($sql);
			echo "<table border='1'>";
			echo "<tr><td>Total Number of 2nd Half Non-Binary - Hispanic Volunteers</td></tr>";
			while ($row = $result->fetch_assoc()) {
			  echo "<tr><td>{$row['TOTAL']}</td></tr>\n";
			}
			echo "</table>";
			
		}
		elseif ($form_demo == "XR") {
			$sql = '(SELECT COUNT(a.f_name) AS TOTAL, a.race AS RACE
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-07-01 00:00:00" AND "2021-01-01 00:00:00" AND a.gender != "Male" AND a.gender != "Female"
					GROUP BY a.race)';
            $result = $db->query($sql);
			echo "<table border='1'>";
			echo "<tr><td>Racial Breakdown of 2nd Half Non-Binary Volunteers</td></tr>";
			while ($row = $result->fetch_assoc()) {
			  echo "<tr><td>{$row['TOTAL']}</td><td>{$row['RACE']}</td></tr>\n";
			}
			echo "</table>";
		}
		else {
			$sql = '(SELECT COUNT(a.f_name) AS TOTAL
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-07-01 00:00:00" AND "2021-01-01 00:00:00")';
			$result = $db->query($sql);
			echo "<table border='1'>";
			echo "<tr><td>Total Number of 2nd Half Volunteers</td></tr>";
			while ($row = $result->fetch_assoc()) {
			  echo "<tr><td>{$row['TOTAL']}</td></tr>\n";
			}
			echo "</table>";
		}
	}
		elseif ($form_time == "Annual") {
		if ($form_demo == "MM") {
			$sql = '(SELECT COUNT(a.f_name) AS TOTAL
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-01-01 00:00:00" AND "2021-01-01 00:00:00" AND a.gender = "Male" AND a.ethnicity = "Hispanic")';
			$result = $db->query($sql);
			echo "<table border='1'>";
			echo "<tr><td>Total Number of Annual Male - Hispanic Volunteers</td></tr>";
			while ($row = $result->fetch_assoc()) {
			  echo "<tr><td>{$row['TOTAL']}</td></tr>\n";
			}
			echo "</table>";
		}
		elseif ($form_demo == "MR") {
			$sql = '(SELECT COUNT(a.f_name) AS TOTAL, a.race AS RACE
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-01-01 00:00:00" AND "2021-01-01 00:00:00" AND a.gender = "Male"
					GROUP BY a.race)';
            $result = $db->query($sql);
			echo "<table border='1'>";
			echo "<tr><td>Racial Breakdown of Annual Male Volunteers</td></tr>";
			while ($row = $result->fetch_assoc()) {
			  echo "<tr><td>{$row['TOTAL']}</td><td>{$row['RACE']}</td></tr>\n";
			}
			echo "</table>";
		}
		elseif ($form_demo == "FM") {
			$sql = '(SELECT COUNT(a.f_name) AS TOTAL
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-01-01 00:00:00" AND "2021-01-01 00:00:00" AND a.gender = "Female" AND a.ethnicity = "Hispanic")';
			$result = $db->query($sql);
			echo "<table border='1'>";
			echo "<tr><td>Total Number of Annual Female - Hispanic Volunteers</td></tr>";
			while ($row = $result->fetch_assoc()) {
			  echo "<tr><td>{$row['TOTAL']}</td></tr>\n";
			}
			echo "</table>";
		}
		elseif ($form_demo == "FR") {
			$sql = '(SELECT COUNT(a.f_name) AS TOTAL, a.race AS RACE
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-01-01 00:00:00" AND "2021-01-01 00:00:00" AND a.gender = "Female"
					GROUP BY a.race)';
           $result = $db->query($sql);
			echo "<table border='1'>";
			echo "<tr><td>Racial Breakdown of Annual Female Volunteers</td></tr>";
			while ($row = $result->fetch_assoc()) {
			  echo "<tr><td>{$row['TOTAL']}</td><td>{$row['RACE']}</td></tr>\n";
			}
			echo "</table>";
		}
		elseif ($form_demo == "XM") {
			$sql = '(SELECT COUNT(a.f_name) AS TOTAL
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-01-01 00:00:00" AND "2021-01-01 00:00:00" AND a.ethnicity = "Hispanic" AND a.gender != "Male" AND a.gender != "Female")';
			$result = $db->query($sql);
			echo "<table border='1'>";
			echo "<tr><td>Total Number of Annual Non-Binary -  Hispanic Volunteers</td></tr>";
			while ($row = $result->fetch_assoc()) {
			  echo "<tr><td>{$row['TOTAL']}</td></tr>\n";
			}
			echo "</table>";
		}
		elseif ($form_demo == "XR") {
			$sql = '(SELECT COUNT(a.f_name) AS TOTAL, a.race AS RACE
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-01-01 00:00:00" AND "2021-01-01 00:00:00" AND a.gender != "Male" AND a.gender != "Female"
					GROUP BY a.race)';
            $result = $db->query($sql);
			echo "<table border='1'>";
			echo "<tr><td>Racial Breakdown of Annual Non-Binary Volunteers</td></tr>";
			while ($row = $result->fetch_assoc()) {
			  echo "<tr><td>{$row['TOTAL']}</td><td>{$row['RACE']}</td></tr>\n";
			}
			echo "</table>";
		}
		else {
			$sql = '(SELECT COUNT(a.f_name) AS TOTAL
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND b.time_in BETWEEN "2020-01-01 00:00:00" AND "2021-01-01 00:00:00")';
			$result = $db->query($sql);
			echo "<table border='1'>";
			echo "<tr><td>Total Number of Annual Volunteers</td></tr>";
			while ($row = $result->fetch_assoc()) {
			  echo "<tr><td>{$row['TOTAL']}</td></tr>\n";
			}
			echo "</table>";
		}
	}
	else {
		if ($form_demo == "MM") {
			$sql = '(SELECT COUNT(a.f_name) AS TOTAL
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND a.gender = "Male" AND a.ethnicity = "Hispanic")';
			$result = $db->query($sql);
			echo "<table border='1'>";
			echo "<tr><td>Total Number of Male - Hispanic Volunteers</td></tr>";
			while ($row = $result->fetch_assoc()) {
			  echo "<tr><td>{$row['TOTAL']}</td></tr>\n";
			}
			echo "</table>";
		}
		elseif ($form_demo == "MR") {
			$sql = '(SELECT COUNT(a.f_name) AS TOTAL, a.race AS RACE
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND a.gender = "Male"
					GROUP BY a.race)';
            $result = $db->query($sql);
			echo "<table border='1'>";
			echo "<tr><td>Racial Breakdown of Male Volunteers</td></tr>";
			while ($row = $result->fetch_assoc()) {
			  echo "<tr><td>{$row['TOTAL']}</td><td>{$row['RACE']}</td></tr>\n";
			}
			echo "</table>";
		}
		elseif ($form_demo == "FM") {
			$sql = '(SELECT COUNT(a.f_name) AS TOTAL
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND a.gender = "Female" AND a.ethnicity = "Hispanic")';
			$result = $db->query($sql);
			echo "<table border='1'>";
			echo "<tr><td>Total Number of Female - Hispanic Volunteers</td></tr>";
			while ($row = $result->fetch_assoc()) {
			  echo "<tr><td>{$row['TOTAL']}</td></tr>\n";
			}
			echo "</table>";
		}
		elseif ($form_demo == "FR") {
			$sql = '(SELECT COUNT(a.f_name) AS TOTAL, a.race AS RACE
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND a.gender = "Female"
					GROUP BY a.race)';
            $result = $db->query($sql);
			echo "<table border='1'>";
			echo "<tr><td>Racial Breakdown of Female Volunteers</td></tr>";
			while ($row = $result->fetch_assoc()) {
			  echo "<tr><td>{$row['TOTAL']}</td><td>{$row['RACE']}</td></tr>\n";
			}
			echo "</table>";
		}
		elseif ($form_demo == "XM") {
			$sql = '(SELECT COUNT(a.f_name)  AS TOTAL
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND a.ethnicity = "Hispanic" AND a.gender != "Male" AND a.gender != "Female")';
			$result = $db->query($sql);
			echo "<table border='1'>";
			echo "<tr><td>Total Number of Non-Binary - Hispanic Volunteers</td></tr>";
			while ($row = $result->fetch_assoc()) {
			  echo "<tr><td>{$row['TOTAL']}</td></tr>\n";
			}
			echo "</table>";
		}
		elseif ($form_demo == "XR") {
			$sql = '(SELECT COUNT(a.f_name) AS TOTAL, a.race AS RACE
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name AND a.gender != "Male" AND a.gender != "Female"
					GROUP BY a.race)';
            $result = $db->query($sql);
			echo "<table border='1'>";
			echo "<tr><td>Racial Breakdown of Non-Binary Volunteers</td></tr>";
			while ($row = $result->fetch_assoc()) {
			  echo "<tr><td>{$row['TOTAL']}</td><td>{$row['RACE']}</td></tr>\n";
			}
			echo "</table>";
		}
		else {
			$sql = '(SELECT COUNT(a.f_name) AS TOTAL
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_inital AND b.l_name = a.l_name)';
			$result = $db->query($sql);
			echo "<table border='1'>";
			echo "<tr><td>Total Number of Volunteers</td></tr>";
			while ($row = $result->fetch_assoc()) {
			  echo "<tr><td>{$row['TOTAL']}</td></tr>\n";
			}
			echo "</table>";
		}
	}
}

if (isset($_POST['not_time_sub'])) {
	$form_noTime = $_POST['noTime'];
	$form_time = $_POST['Time'];
	$form_demo = $_POST['demo'];
	if ($form_noTime == 'eachVol') {
		$sql = '(SELECT COUNT(a.f_name) AS TOTAL
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_initial AND b.l_name=a.l_name)';
        $result = $db->query($sql);
		echo "<table border='1'>";
		echo "<tr><td>Total Number of Volunteers</td></tr>";
		while ($row = $result->fetch_assoc()) {
		    echo "<tr><td>{$row['TOTAL']}</td></tr>\n";
		}
		echo "</table>";
	}
	elseif ($form_noTime == 'Newsletter') {
        $querry = '(SELECT f_name AS FIRST, m_initial AS MIDDLE, l_name AS LAST, email_address AS EMAIL
                        FROM VOLUNTEER
                        WHERE e_newsletter = 1)';
       $result = $db->query($sql);
		echo "<table border='1'>";
		echo "<tr><td>First</td><td>Middle</td><td>Last</td><td>Email</td></tr>";
		while ($row = $result->fetch_assoc()) {
		   echo "<tr><td>{$row['FIRST']}</td><td>{$row['MIDDLE']}</td><td>{$row['LAST']}</td><td>{$row['EMAIL']}</td></tr>\n";
			}
		echo "</table>";
	}
	else {
		$sql = '(SELECT a.f_name AS FIRST, a.m_initial AS MIDDLE, a.l_name AS LAST, SUM(b.time_worked) AS TIME_WORKED, a.required_hours AS REQUIRED
					FROM VOLUNTEER a, HOURS b
					WHERE b.f_name = a.f_name AND b.m_initial = a.m_initial AND b.l_name=a.l_name AND a.required_hours IS NOT NULL)';
        $result = $db->query($sql);
		echo "<table border='1'>";
		echo "<tr><td>First</td><td>Middle</td><td>Last</td><td>Time Worked</td><td>Required Time</td></tr>";
		while ($row = $result->fetch_assoc()) {
		   echo "<tr><td>{$row['FIRST']}</td><td>{$row['MIDDLE']}</td><td>{$row['LAST']}</td><td>{$row['TIME_WORKED']}</td><td>{$row['REQUIRED']}</td></tr>\n";
			}
		echo "</table>";
	}
}
?>
<form method ="post" action="http://ec2-54-237-6-145.compute-1.amazonaws.com/src/reports.php">
	<label for="time">Time Period:</label>
  <select name="Time">
    <option value="Q1">Q1</option>
    <option value="Q2">Q2</option>
    <option value="Q3">Q3</option>
    <option value="Q4">Q4</option>
    <option value="First">First Half of the Year</option>
    <option value="Second">Second half of the Year</option>
    <option value="Annual">Annual</option>
    <option value="None">N/A</option>
  </select> <br>
    <label for="demo">Demographics:</label>
  <select name="demo">
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
  <select name="noTime">
    <option value="eachVol">Total Number of Volunteers</option>
    <option value="Newsletter">Newsletter</option>
    <option value="comServ">Community Service</option>
   </select>
   <input type="submit" name="not_time_sub" value="Submit for Not Time">
</form>
<br><br><br><br><br>
   ---------------------------------------------------------------------------------------
<br><br><br>

<textarea name='query_result_data'></textarea>

<?php
make_html_end();

?>