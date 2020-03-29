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
    $first = $db->real_escape_string($_POST['first']);
    $middle = $db->real_escape_string($_POST['middle']);
    $last = $db->real_escape_string($_POST['last']);
    $race = $db->real_escape_string($_POST['race']);
    $ethnicity = $db->real_escape_string($_POST['ethnicity']);
    $gender = $db->real_escape_string($_POST['gender']);
    $veteran_status = $db->real_escape_string($_POST['veteran_status']);
    $volunteer_type = $db->real_escape_string($_POST['volunteer_type']);
    $refered_from = $db->real_escape_string($_POST['referred_from']);
    $birth_date = $db->real_escape_string($_POST['birth_date']);
    $email_address = $db->real_escape_string($_POST['email_address']);
    $phone_number = $db->real_escape_string($_POST['phone_number']);
    $country = '0';
    $street = $db->real_escape_string($_POST['street']);
    $state = $db->real_escape_string($_POST['state']);
    $city = $db->real_escape_string($_POST['city']);
    $postal_code = $db->real_escape_string($_POST['postal_code']);
    $country = $db->real_escape_string($_POST['country']);
    $emergency_fname = $db->real_escape_string($_POST['emergency_fname']);
    $emergency_lname = $db->real_escape_string($_POST['emergency_lname']);
    $emergency_phone = $db->real_escape_string($_POST['emergency_phone']);
    $emergency_relationship = $db->real_escape_string($_POST['emergency_relationship']);
    $e_newsletter = $db->real_escape_string($_POST['e_newsletter']);



    $sql = 'INSERT INTO VOLUNTEER '.
	    '(f_name,m_initial,l_name,race,ethnicity,gender,veteran_status,volunteer_type,refered_from,birth_date,email_address,phone_number,country,street_address,state_providence,city,postal_code,emergency_fName,emergency_lName,emergency_relationship) '.
	    "VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
      if ($stmt = $db->prepare($sql)) {
                $stmt->bind_param("sssssssssssdsssssssss", $first, $middle, $last, $race, $ethnicity, $gender, $veteran_status, $volunteer_type, $refered_from, $birth_date, $email_address, $phone_number $country, $street, $state, $city, $postal_code, $emergency_fname, $emergency_lname, $emergency_relationship);
                $stmt->execute();
                $count =  $stmt->store_result();
                if ($stmt) {
                  echo "Added " . $first " to the database!";
                }
                else {
                  echo "Something went wrong!";
                }
                $stmt->free_result();

                  /* if ($stmt->rowCount() === 0)
                    {echo "Your name wasn't found. Please check spelling and try again";}
                  else {
                    echo "Punched in!";
                } */
            }

    if (!$stmt) {
      echo "Error : " . $stmt . "<br>" . $con->error;
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
    $db = conn_db();
    if ($db->connect_error) {
      die("Connection failed: " . $db->connect_error);
                            }
    }

    volunteer_add();
}
else
{
    volunteer_add_form();
}



public_html_end();

?>
