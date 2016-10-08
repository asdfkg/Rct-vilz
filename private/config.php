<?php
// error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// set timezone
date_default_timezone_set('America/New_York');

// define constants
define('HTTP_PATH', '/villazzo_new/');
define('EMAILS_PATH', HTTP_PATH.'/emails/');

// class include
require_once 'class/database.php';
require_once 'class/user.php';
require_once 'class/smtp.php';
require_once 'class/mailer.php';
require_once 'class/utility.php';
require_once 'class/setting.php';
require_once 'class/reservation.php';
require_once('class/FPDF/fpdf.php');
require_once('class/FPDI/fpdi.php');

// start session
if (!isset($_SESSION)) session_start();

// create a new Database object
if (!isset($_SESSION['DB'])) $_SESSION['DB'] = new Database();

// create a new User object
if (!isset($_SESSION['USER']))
{
	$_SESSION['USER'] = new User();
	if (isset($_COOKIE['USER_TOKEN'])) $_SESSION['USER']->login();
}

// create a new Utility object
if (!isset($_SESSION['UTILITY'])) $_SESSION['UTILITY'] = new Utility();

// create a new Setting object
if (!isset($_SESSION['SETTING'])) $_SESSION['SETTING'] = new Setting();

// create a new Reservation object
if (!isset($_SESSION['RESERVATION'])) $_SESSION['RESERVATION'] = new Reservation();

// redirect from login page depending on cookie or user id
if (basename($_SERVER['PHP_SELF']) == '/login' && (isset($_COOKIE['USER_TOKEN']) || $_SESSION['USER']->getUserId())) $_SESSION['USER']->login();

// logout
if (isset($_GET['logout'])) $_SESSION['USER']->logout('/');

function getMeta($name)
{
	$rs_meta = $_SESSION['DB']->querySelect('SELECT PAGE_META_TITLE, PAGE_META_DESC, PAGE_META_KEYWORDS FROM PAGE_META WHERE PAGE_META_NAME = ? LIMIT 1', array($name));
	$row_rs_meta = $_SESSION['DB']->queryResult($rs_meta);
	$totalRows_rs_meta = $_SESSION['DB']->queryCount($rs_meta);
	
	echo '<title>'.$row_rs_meta['PAGE_META_TITLE'].'</title>
	<meta name="Description" content="'.$row_rs_meta['PAGE_META_DESC'].'" />
	<meta name="Keywords" content="'.$row_rs_meta['PAGE_META_KEYWORDS'].'" />';
}

function getContent($name)
{
	$rs_content = $_SESSION['DB']->querySelect('SELECT PAGE_TEXT_ID, PAGE_TEXT_NAME, PAGE_TEXT_VALUE FROM PAGE_TEXT WHERE PAGE_TEXT_NAME = ? AND PAGE_TEXT_DT = (SELECT MAX(PAGE_TEXT_DT) FROM PAGE_TEXT WHERE PAGE_TEXT_NAME = ? LIMIT 1)', array($name, $name));
	$row_rs_content = $_SESSION['DB']->queryResult($rs_content);
	$totalRows_rs_content = $_SESSION['DB']->queryCount($rs_content);
	//if($_SESSION['USER']->getUserId()) echo "<a class=\"cmsContent\" href=\"/cms/content/modal-content.php?id=".$row_rs_content['PAGE_TEXT_ID']."\" style=\"color:#000; text-decoration:none;\" title=\"Click to edit\">".$row_rs_content['PAGE_TEXT_VALUE']."</a>";
	//else 
	echo $row_rs_content['PAGE_TEXT_VALUE'];
}
?>