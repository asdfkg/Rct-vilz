<?php
require_once '/kunden/homepages/27/d309616710/htdocs/private/config.php';

// restrict user access
$_SESSION['USER']->restrict('1,2,3,4');

if (isset($_POST['action']) && $_POST['action'] == 'update' && $_POST['firstName'] != '' && $_POST['lastName'] != '' && $_POST['userEmail'] != '' && $_POST['userPassword'] != '')
{
	if (strpos($_POST['userPassword'], '*') === false)
	{
		$_SESSION['DB']->queryUpdate('UPDATE USER SET USER_PASSWORD = AES_ENCRYPT(?, \''.$_SESSION['DB']->getEncryptKey().'\') WHERE USER_ID = ? LIMIT 1', array($_POST['userPassword'], $_POST['userId']));
	}
	
	$_SESSION['DB']->queryUpdate('UPDATE USER SET USER_FIRSTNAME = ?, USER_LASTNAME = ?, USER_EMAIL = ?, USER_COMPANY = ? WHERE USER_ID = ? LIMIT 1',
	array(
		$_POST['firstName'],
		$_POST['lastName'],
		$_POST['userEmail'],
		$_POST['userCompany'],
		$_POST['userId']
	));
	header('Location: /reservations/');
}

$colname_rs_user = "-1";
if(isset($_GET['id'])) {
  $colname_rs_user = $_GET['id'];
}
$rs_user = $_SESSION['DB']->querySelect('SELECT USER_ID, USERGROUP_ID, USER_EMAIL, USER_FIRSTNAME, USER_LASTNAME, AES_DECRYPT(USER_PASSWORD, \''.$_SESSION['DB']->getEncryptKey().'\') AS unencrypted, USER_COMPANY, USER_COMMISSION_VH, USER_COMMISSION_BL FROM USER WHERE USER_ID = ? LIMIT 1', array($_SESSION['USER']->getUserId()));
$row_rs_user = $_SESSION['DB']->queryResult($rs_user);
$totalRows_rs_user = $_SESSION['DB']->queryCount($rs_user);

$rs_usergroup = $_SESSION['DB']->querySelect('SELECT * FROM USERGROUP');
$row_rs_usergroup = $_SESSION['DB']->queryResult($rs_usergroup);
$totalRows_rs_usergroup = $_SESSION['DB']->queryCount($rs_usergroup);

$rs_property = $_SESSION['DB']->querySelect('SELECT propertyOwner.propertyId, propertyName FROM propertyOwner LEFT JOIN property ON property.propertyId = propertyOwner.propertyId WHERE userId = ? ORDER BY propertyName ASC', array($colname_rs_user));
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
                    <h1>USER EDIT</h1>
                </div>
            </div>
        </section>

        <section>
            <div class="row">
                <div class="columns">
	                
	                
			      <form action="" method="post" name="userEditForm" id="userEditForm">
			        <input name="userId" id="userId" type="hidden" value="<?php echo $row_rs_user['USER_ID']; ?>" />
			        <input type="hidden" name="action" value="update" />
			        <table border="0" cellspacing="0" cellpadding="2">
			          <?php if($row_rs_user['USERGROUP_ID'] == 3) { ?>
			          <tr>
			            <td valign="top">Property</td>
			            <td valign="top"><?php do { echo $row_rs_property['propertyName']." | "; } while ($row_rs_property = $_SESSION['DB']->queryResult($rs_property)); ?></td>
			          </tr>
			          <?php } ?>
			          <tr>
			            <td valign="top">First Name</td>
			            <td valign="top"><input name="firstName" id="firstName" type="text" value="<?php echo $row_rs_user['USER_FIRSTNAME']; ?>" class="textField" /></td>
			          </tr>
			          <tr>
			            <td valign="top">Last Name</td>
			            <td valign="top"><input name="lastName" id="lastName" type="text" value="<?php echo $row_rs_user['USER_LASTNAME']; ?>" class="textField" /></td>
			          </tr>
			          <tr>
			            <td valign="top">Company</td>
			            <td valign="top"><input name="userCompany" id="userCompany" type="text" value="<?php echo $row_rs_user['USER_COMPANY']; ?>" class="textField" /></td>
			          </tr>
			          <tr>
			            <td valign="top">Email</td>
			            <td valign="top"><input name="userEmail" id="userEmail" type="text" value="<?php echo $row_rs_user['USER_EMAIL']; ?>" class="textField" /></td>
			          </tr>
			          <tr>
			            <td valign="top">Password</td>
			            <td valign="top"><input name="userPassword" id="userPassword" value="<?php echo $_SESSION['UTILITY']->formatPassword($row_rs_user['unencrypted']); ?>" class="textField" /></td>
			          </tr>
			          <tr>
			            <td valign="top">Commission VillaHotel (%)</td>
			            <td valign="top"><input name="userCommissionVillaHotel" id="userCommissionVillaHotel" type="text" value="<?php echo $row_rs_user['USER_COMMISSION_VH']; ?>" class="textField" disabled="disabled" /></td>
			          </tr>
			          <tr>
			            <td valign="top">Commission Basic Linen (%)</td>
			            <td valign="top"><input name="userCommissionBasicLinen" id="userCommissionBasicLinen" type="text" value="<?php echo $row_rs_user['USER_COMMISSION_BL']; ?>" class="textField" disabled="disabled" /></td>
			          </tr>
			          <tr>
			            <td valign="top">&nbsp;</td>
			            <td valign="top"><input type="submit" class="button" name="userEditBtn" id="userEditBtn" value="Save" /></td>
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
