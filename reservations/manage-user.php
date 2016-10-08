<?php
require_once '/kunden/homepages/27/d309616710/htdocs/private/config.php';

// restrict user access
$_SESSION['USER']->restrict('1,2,4');

$rs_user = $_SESSION['DB']->querySelect('SELECT a.LAST_USER_LOG_DT, USERGROUP_NAME, USER . * FROM USER LEFT JOIN USERGROUP ON USERGROUP.USERGROUP_ID = USER.USERGROUP_ID LEFT JOIN (SELECT MAX( USER_LOG_DT ) AS LAST_USER_LOG_DT, USER_ID FROM USER_LOG GROUP BY USER_ID) AS a ON a.USER_ID = USER.USER_ID');
$row_rs_user = $_SESSION['DB']->queryResult($rs_user);
$totalRows_rs_user = $_SESSION['DB']->queryCount($rs_user);

if (isset($_GET['action']) && $_GET['action'] == 'deleteUser')
{
	$_SESSION['DB']->queryUpdate('DELETE FROM USER WHERE USER_ID = ?', array($_GET['userId']));
	header('Location: /reservations/user');
}

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
                    <h1>USERS</h1>
                </div>
            </div>
        </section>

        <section>
            <div class="row">
                <div class="columns">
	                
	                
	                
	                  <div style="float:left; width:100%;">
  <p><a href="/reservations/user/add">Add a new user</a></p>
  <p>
    <table border="0" cellspacing="0" cellpadding="0">
      <tr style="font-weight:bold">
        <td valign="top" style="width:150px;">Type</td>
        <td valign="top" style="width:200px;">Name</td>
        <td valign="top" style="width:250px;">Email</td>
        <td valign="top" style="width:150px;">Created</td>
        <td valign="top" style="width:150px;">Last Login</td>
        <td valign="top" style="width:50px;">&nbsp;</td>
        </tr>
      <tr>
        <td valign="top" colspan="6" style="background-color:#dac172; height:5px; padding:0px;">&nbsp;</td>
      </tr>
      <?php do { /*if($row_rs_user['USERGROUP_ID']!=4) {*/ ?>
        <tr>
          <td valign="top"><?php echo $row_rs_user['USERGROUP_NAME']; ?></td>
          <td valign="top"><a href="/reservations/user/<?php echo $row_rs_user['USER_ID']; ?>"><?php echo $row_rs_user['USER_FIRSTNAME'].' '.$row_rs_user['USER_LASTNAME']; ?></a></td>
          <td valign="top"><?php echo $row_rs_user['USER_EMAIL']; ?></td>
          <td valign="top"><?php echo $_SESSION['UTILITY']->dateReservation($row_rs_user['USER_CREATE_DT']); ?></td>
          <td valign="top"><?php if($row_rs_user['LAST_USER_LOG_DT']) echo $_SESSION['UTILITY']->dateReservation($row_rs_user['LAST_USER_LOG_DT']); else echo "NEVER"; ?></td>
          <td valign="top"><a href="?action=deleteUser&userId=<?php echo $row_rs_user['USER_ID']; ?>"><i class="fa fa-trash-o" title="Delete user"></i></a></td>
          </tr>
        <?php /*}*/ } while ($row_rs_user = $_SESSION['DB']->queryResult($rs_user)); ?>
    </table></p></div>
</div>

	                
	                
	                
                </div>
            </div>
        </section>

    <?php require_once '../inc-footer.php'; ?>
	
	<?php require_once '../inc-js.php'; ?>
</body>

</html>
