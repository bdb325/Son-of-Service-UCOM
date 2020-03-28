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

require_once (SOS_PATH . 'include/global.php');
require_once (SOS_PATH . 'include/config.php');
require_once (SOS_PATH . 'functions/html.php');


make_html_begin(_("Add a volunteer"), array());


echo "<h3>" . _("Add a volunteer") . "</h3>\n";

function volunteer_add()
{
    global $db;


    // validate form input

    $errors_found = 0;

    if (2 > (strlen(trim($_POST['last'])) + strlen(trim($_POST['organization']))))
    {
       process_user_error(_("Please enter a longer last name or organization."));
       $errors_found++;
    }

/*    if (!has_permission(PC_VOLUNTEER, PT_WRITE, NULL, NULL))
    {
	process_user_error(_("Insufficient permissions."));
	$errors_found++;
} */ //Login check

    if ($errors_found)
    {
	  echo ("<P>Try <A href=\"publicvolunteer.php\">again</A>.</P>\n");
	  // todo: redisplay form here with values in place
	  die();
    }

    $organization = $db->qstr(htmlentities($_POST['organization']), get_magic_quotes_gpc());

    //$prefix = $db->qstr(htmlentities($_POST['prefix']), get_magic_quotes_gpc());
    $first = $db->qstr(htmlentities($_POST['first']), get_magic_quotes_gpc());
    $middle = $db->qstr(htmlentities($_POST['middle']), get_magic_quotes_gpc());
    $last = $db->qstr(htmlentities($_POST['last']), get_magic_quotes_gpc());
    $race = $db->qstr(htmlentities($_POST['race']));
    $ethnicity = $db->qstr(htmlentities($_POST['ethnicity']));
    $gender = $db->qstr(htmlentities($_POST['gender']));
    $veteran_status = $db->qstr(htmlentities($_POST['veteran_status']));
    $volunteer_type = $db->qstr(htmlentities($_POST['volunteer_type']));
    $refered_from = $db->qstr(htmlentities($_POST['referred_from']));
    $birth_date = $db->qstr(htmlentities($_POST['birth_date']));
    $email_address = $db->qstr(htmlentities($_POST['email_address']), get_magic_quotes_gpc());
    $phone_number = $db->qstr(htmlentities($_POST['phone_number']));
    $country = $db->qstr(htmlentities($_POST['country']));
    $street = $db->qstr(htmlentities($_POST['street']), get_magic_quotes_gpc());
    $state = $db->qstr(htmlentities($_POST['state']), get_magic_quotes_gpc());
    $city = $db->qstr(htmlentities($_POST['city']), get_magic_quotes_gpc());
    $postal_code = $db->qstr(htmlentities($_POST['postal_code']), get_magic_quotes_gpc());
    $country = $db->qstr(htmlentities($_POST['country']), get_magic_quotes_gpc());
    $emergency_fname = $db->qstr(htmlentities($_POST['emergency_fname']));
    $emergency_lname = $db->qstr(htmlentities($_POST['emergency_lname']));
    $emergency_phone = $db->qstr(htmlentities($_POST['emergency_phone']));
    $emergency_relationship = $db->qstr(htmlentities($_POST['emergency_relationship']));
    $e_newsletter = $db->qstr(htmlentities($_POST['e_newsletter']));



    $sql = 'INSERT INTO VOLUNTEER '.
	    '(f_name,m_initial,l_name,race,ethnicity,gender,veteran_status,volunteer_type,refered_from,birth_date,email_address,phone_number,country,street_address,state_providence,city,postal_code,emergency_fName,emergency_lName,emergency_relationship) '.
	    "VALUES ($first, $middle, $last, $race, $ethnicity, $gender, $veteran_status, $volunteer_type, $refered_from, $birth_date, $email_address, $phone_number, 'US', $street, 'MI', 'Marysville', $postal_code, $emergency_fname, $emergency_lname, $emergency_relationship)";

    $result = $db->Execute($sql);

    if (!$result)
    {
	die_message(MSG_SYSTEM_ERROR, _("Error adding data to database."), __FILE__, __LINE__, $sql);
    }

    $vid = $db->Insert_ID();

    // insert phone number records
/*
    if (!empty($_POST['phone_home']) or !empty($_POST['phone_work']) or !empty($_POST['phone_cell']))
    {
	// select an empty record

	$sql = "SELECT * FROM phone_numbers WHERE 0 = 1";
	$template_result = $db->Execute($sql);
	if (!$template_result)
	{
	    die_message(MSG_SYSTEM_ERROR, _("Error querying database."), __FILE__, __LINE__, $sql);
	}

	$record['volunteer_id'] = $vid;
    }

    if (!empty($_POST['phone_home']))
    {
	$record['number'] =  htmlentities($_POST['phone_home']);
	$record['memo'] = _("Home");
	$sql = $db->GetInsertSql($template_result, $record);
	$result = $db->Execute($sql);
	if (!$result)
	{
	    // todo: roll back
	    die_message(MSG_SYSTEM_ERROR, _("Error adding data to database."), __FILE__, __LINE__, $sql);
	}
    }

    if (!empty($_POST['phone_work']))
    {
	$record['number'] =  htmlentities($_POST['phone_work']);
	$record['memo'] = _("Work");
	$sql = $db->GetInsertSql($template_result, $record);
	$result = $db->Execute($sql);
	if (!$result)
	{
	    // todo: roll back
	    die_message(MSG_SYSTEM_ERROR, _("Error adding data to database."), __FILE__, __LINE__, $sql);
	}
    }

    if (!empty($_POST['phone_cell']))
    {
	$record['number'] =  htmlentities($_POST['phone_cell']);
	$record['memo'] = _("Cell");
	$sql = $db->GetInsertSql($template_result, $record);
	$result = $db->Execute($sql);
	if (!$result)
	{
	    // todo: roll back
	    die_message(MSG_SYSTEM_ERROR, _("Error adding data to database."), __FILE__, __LINE__, $sql);
	}
    }
*/ //THIS IS THE STUFF I COMMENTED OUT TO TEST
    // display success message

    $volunteer_row = volunteer_get($vid, $errstr);

    if ($volunteer_row)
    {
        echo ("<P>" . _("Added:") . " <A href=\"". SOS_PATH . "volunteer/?vid=$vid\">" . make_volunteer_name($volunteer_row) . ' (#'.$vid.")</A>.</P>\n");
    }
    else
    {
	echo ("<P>volunteer_get() error:  $errstr</P>\n");
    }


} /* add_volunteer() */


function volunteer_add_form()
{
?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

<table border="0" width="50%" cellspacing="0" cellpadding="0">
<tr>
 <th class="vert"><?php echo _("First name"); ?></th>
 <td><input type="Text" name="first"></td>
 </tr>
<tr>
 <th class="vert"><?php echo _("Middle Initial"); ?></th>
 <td><input type="Text" name="middle"></td>
 </tr>
<tr>
 <th class="vert"><?php echo _("Last name"); ?></th>
 <td><input type="Text" name="last"></td>
 </tr>
 <tr>
  <tr>
    <th class="vert"><?php echo _("Birth date"); ?></th>
    <td><input type="date" name="birth_date"> </td>
  </tr>
  <th class ="vert"><?php echo _("Ethnicity"); ?></th>
  <td> <select id="ethnicity" name="ethnicity">
     <option value="Hispanic">Hispanic</option>
     <option value="Non-hispanic">Non-hispanic</option>
     <option value="N/A">N/A</option>
   </td>
 </tr>
 <tr>
   <th class ="vert"><?php echo _("Race"); ?></th>
  <td> <select id="race" name="race">
  <option value="African">African</option>
  <option value="African American/Black">African American</option>
  <option value="Asian">Asian</option>
  <option value="Caucasian/White">Caucasian/White</option>
  <option value="Native American">Native American</option>
  <option value="Native Pacific Islander">Native Pacific Islander</option>
  <option value="Native Alaskan">Audi</option>
  <option value="Multi-racial">Multi-racial</option>
  <option value="Other">Other</option>
  <option value="N/A">N/A</option>
</td>
</select>
 </tr>
 <tr>
   <th class="vert"><?php echo _("Gender Identity"); ?></th>
   <td> <select id="gender" name="gender">
     <option value="Male">Male</option>
     <option value="Female">Female</option>
     <option value="Non-binary">Non-binary</option>
     <option value="N/A">N/A</option>
   </select>
 </td>
</tr>
<tr>
  <th class ="vert"><?php echo _("Please select your preferred area of work"); ?></th>
 <td> <select id="volunteer_type" name="volunteer_type">
 <option value="Art">Art/design/decorating</option>
 <option value="Maintenance">Building maintenance</option>
 <option value="Clothing">Clothing retail</option>
 <option value="Computer">Computer work/data entry</option>
 <option value="Custodial">Custodial/cleaning</option>
 <option value="Driving">Driving (must provide license & insurance)</option>
 <option value="Food packing">Food packing & repacking</option>
 <option value="Gardening">Gardening/landscaping</option>
 <option value="Grocery Stocking">Grocery stocking</option>
 <option value="Grocery checkout">Grocery checkout</option>
 <option value="Loading">Loading dock (unloading trucks)</option>
 <option value="Office">Office work(copying,filing,etc)</option>
 <option value="Reception">Reception/greeter/phone management</option>
 <option value="Translating">Translating other languages</option>
 <option value="Vehicle">Vehicle maintenance/auto detailing</option>
 <option value="Children">Working with children</option>
</td>
</select>
</tr>
<tr>
  <th class="vert"><?php echo _("Are you a veteran?"); ?></th>
  <td> <select id="veteran_status" name="veteran_status">
    <option value="Yes">Yes</option>
    <option value="No">No</option>
    <option value="N/A">N/A</option>
  </select>
</td>
</tr>
 <tr>
  <th class="vert"><?php echo _("Country"); ?></th>
  <td>
    <select name="country" class="countries order-alpha include-CA-MX-US presel-US" id="countryId">
        <option value="">Select Country</option>
    </select>
  </td>
  </tr>

  <tr>
   <th class="vert"><?php echo _("State/Province"); ?></th>
   <td>
     <select name="state" class="states order-alpha" id="stateId">
         <option value="">Select State</option>
     </select>
     </td>
   </tr>
<tr>
 <th class="vert"><?php echo _("City"); ?></th>
 <td>
   <select name="city" class="cities order-alpha" id="cityId">
       <option value="">Select City</option>
   </select>
 </td>
 </tr>
<tr>
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="//geodata.solutions/includes/countrystatecity.js"></script>
<tr>
  <th class="vert"><?php echo _("Street"); ?></th>
  <td><input type="Text" name="street"></td>
</tr>
 <th class="vert"><?php echo _("Zip/Postal code"); ?></th>
 <td><input type="Text" name="postal_code"></td>
 </tr>

<tr>
 <th class="vert"><?php echo _("Phone number"); ?></th>
 <td><input type="Text" name="phone_number"></td>
 </tr>
<tr>
 <th class="vert"><?php echo _("E-mail"); ?></th>
 <td><input type="Text" name="email_address"></td>
 </tr>
 <tr>
  <th class="vert"><?php echo _("Emergency Contact First Name"); ?></th>
  <td><input type="Text" name="emergency_fname"></td>
  </tr>
 <tr>
  <th class="vert"><?php echo _("Emergency Contact Last Name"); ?></th>
  <td><input type="Text" name="emergency_lname"></td>
  </tr>
 <tr>
  <th class="vert"><?php echo _("Emergency Phone Number"); ?></th>
  <td><input type="Text" name="emergency_phone"></td>
  </tr>
  <tr>
   <th class="vert"><?php echo _("Relation of Emergency Contact"); ?></th>
   <td><input type="Text" name="emergency_relationship"></td>
   </tr>

</table>
<input type="submit" name="button_add_volunteer" value="<?php echo _("Add");?>">

</form>

<?php

} /* volunteer_add_form() */

if (array_key_exists('button_add_volunteer', $_POST))
{
    $db = connect_db();

    if (!$db)
    {
        die_message(MSG_SYSTEM_ERROR, _("Error establishing database connection."), __FILE__, __LINE__);
    }

    volunteer_add();
}
else
{
    volunteer_add_form();
}



public_html_end();

?>
