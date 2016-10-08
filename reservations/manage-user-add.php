<?php
require_once '/kunden/homepages/27/d309616710/htdocs/private/config.php';

// restrict user access
$_SESSION['USER']->restrict('1,2,4');

if (isset($_POST['action']) && $_POST['action'] == 'add' && $_POST['userGroup'] != '' && $_POST['firstName'] != '' && $_POST['lastName'] != '' && $_POST['userEmail'] != '' && $_POST['userPassword'] != '')
{
	$userId = $_SESSION['DB']->queryInsert('INSERT INTO USER (USERGROUP_ID, USER_FIRSTNAME, USER_LASTNAME, USER_EMAIL, USER_PASSWORD, USER_COMMISSION_VH, USER_COMMISSION_BL) VALUES (?, ?, ?, ?, AES_ENCRYPT(?, \''.$_SESSION['DB']->getEncryptKey().'\'),?, ?)',
	array(
		$_POST['userGroup'],
		$_POST['firstName'],
		$_POST['lastName'],
		$_POST['userEmail'],
		$_POST['userPassword'],
		$_POST['userCommissionVillaHotel'],
		$_POST['userCommissionBasicLinen']
	));
  
	if (isset($_POST['property']) && $_POST['property'] != '')
	{
		foreach($_POST['property'] as $key=>$value)
		{
			$_SESSION['DB']->queryInsert('INSERT INTO propertyOwner (propertyId, userId) VALUES (?, ?)', array($value, $userId));
		}  
	}
	header('Location: /reservations/user');
}

$rs_usergroup = $_SESSION['DB']->querySelect('SELECT * FROM USERGROUP');
$row_rs_usergroup = $_SESSION['DB']->queryResult($rs_usergroup);
$totalRows_rs_usergroup = $_SESSION['DB']->queryCount($rs_usergroup);

$rs_property = $_SESSION['DB']->querySelect('SELECT propertyId, propertyName FROM property ORDER BY propertyName ASC');
$row_rs_property = $_SESSION['DB']->queryResult($rs_property);
$totalRows_rs_property = $_SESSION['DB']->queryCount($rs_property);
?>
<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>Reservations - VILLAZZO</title>
    <link rel="stylesheet" href="/css/custom.css">
    <script src="/js/vendor/modernizr.js"></script>
</head>

<body>
	<?php require_once '../inc-header.php'; ?>

        <section id="header-section">
            <img src="/img/destination-header_all.png">
        </section>


        <section id="reservations-title-steps-section">
            <div class="row">
                <div class="columns">
                    <h1>USER ADD</h1>
                </div>
            </div>
        </section>

        <section>
            <div class="row">
                <div class="columns">
	                
	                
	                
      <form action="" method="post" name="userAddForm" id="userAddForm">
        <input type="hidden" name="action" value="add" />
        <table border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td valign="top">User Type</td>
            <td valign="top"><select name="userGroup" id="userGroup" onchange="if(this.value==3) document.getElementById('propertyDropDown').style.display='';" class="dropDown">
                <option value="">---</option>
                <?php do { /*if($row_rs_usergroup['USERGROUP_ID']!=4) {*/ ?>
                <option value="<?php echo $row_rs_usergroup['USERGROUP_ID']; ?>"><?php echo $row_rs_usergroup['USERGROUP_NAME']; ?></option>
                <?php /*}*/ } while ($row_rs_usergroup = $_SESSION['DB']->queryResult($rs_usergroup)); ?>
              </select></td>
          </tr>
          <tr id="propertyDropDown" style="display:none;">
            <td valign="top">Property</td>
            <td valign="top"><?php do { ?>
                <input name="property[]" type="checkbox" value="<?php echo $row_rs_property['propertyId']; ?>" />
                <?php echo $row_rs_property['propertyName']; ?><br />
                <?php } while ($row_rs_property = mysql_fetch_assoc($rs_property)); ?></td>
          </tr>
          <tr>
            <td valign="top">First Name</td>
            <td valign="top"><input name="firstName" id="firstName" type="text" class="textField" /></td>
          </tr>
          <tr>
            <td valign="top">Last Name</td>
            <td valign="top"><input name="lastName" id="lastName" type="text" class="textField" /></td>
          </tr>
          <tr>
            <td valign="top">Company</td>
            <td valign="top"><input name="userCompany" id="userCompany" type="text" class="textField" /></td>
          </tr>
          <tr>
            <td valign="top">Email</td>
            <td valign="top"><input name="userEmail" id="userEmail" type="text" class="textField" /></td>
          </tr>
          <tr>
            <td valign="top">Password</td>
            <td valign="top"><input name="userPassword" id="userPassword" type="text" class="textField" /></td>
          </tr>
          <tr>
            <td valign="top">Commission VillaHotel (%)</td>
            <td valign="top"><input name="userCommissionVillaHotel" id="userCommissionVillaHotel" type="text" class="textField" /></td>
          </tr>
          <tr>
            <td valign="top">Commission Basic Linen (%)</td>
            <td valign="top"><input name="userCommissionBasicLinen" id="userCommissionBasicLinen" type="text" class="textField" /></td>
          </tr>
          <tr>
            <td valign="top">&nbsp;</td>
            <td valign="top"><input type="submit" class="button" name="userAddBtn" id="userAddBtn" value="Submit" /></td>
          </tr>
        </table>
      </form>




                </div>
            </div>
        </section>

    <?php require_once '../inc-footer.php'; ?>
	
	<?php require_once '../inc-js.php'; ?>
</body>

</html>
