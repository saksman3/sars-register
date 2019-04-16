<?php
//include ('config.php');

/* ==================================================================
Script name : 	SARS Server Register.
		Based on the Simple CMS written by Dave le Roux
Author : 	Dave le Roux
Date : 		16th Feb 2011
Updated :	11th May 2011
Purpose : 	This script is intended to manage the SARS Unix team 
		Server register.

Requirements :
	This script requires the following dependencies.
	php-snmp
	
=====================================================================*/


error_reporting(E_ALL);

include("functions.php");

session_start();
if ( !isset($_SESSION['username']) ) {
	$_SESSION['username'] = "Guest";
	$_SESSION['userfullname'] = "Guest";
	$_SESSION['userlevel'] = 1;
	$_SESSION['failed'] = 0;
	$_SESSION['sort'] = 'IPAddress';

}

$UserName = $_SESSION['username'];
$UserFullName = $_SESSION['userfullname'];
$UserLevel = $_SESSION['userlevel'];
$LoginFailed = $_SESSION['failed'];

$PageHeader = new layout;

echo $PageHeader->Header( "The SARS Unix team tool box." );

if ( isset( $_POST['Login'] ) ) {

	$UserToBe = $_POST['username'];
	$md5_password = md5( $_POST['password'] );

	include("config.php");

	$query = "select * from users where UserName='$UserToBe' and Password='$md5_password'";
	$LoginCheck = $GLOBALS['conn']->query($query);
	$count = mysqli_num_rows($LoginCheck);
	if ($count != '0' ) { 
		$row = $LoginCheck->fetch_assoc();
		print_r($row);
		/* exit(); */
		$_SESSION['username'] =  $row["UserName"];
		$_SESSION['userfullname'] = $row["FullName"];
		$_SESSION['userlevel'] = $row["Level"];
		$_SESSION['failed'] = 0;
		$DateNow = date("Y-m-d H:i:s");
		

	//$LoginCheck = mysql_query("); 
		$sql = "UPDATE users SET LastLogin=? WHERE UserName=?";
		$stmt = $GLOBALS['conn']->prepare($sql) or die("failed to prepare");
   echo"date"."-".$DateNow;
		$stmt->bind_param('ss',$DateNow,$_SESSION['username']) or die("bind_param failed");
		$stmt->execute() or die("failed exec");
		$stmt->close();
        header( "Location: index.php?" );
	} else {

		$_SESSION['failed'] = 1;

	}

   $GLOBALS['conn']->close();
}

if (isset($_GET['option'])){

	$action = $_GET['option'];

} else {

	if ( $_SESSION['failed'] ) {

		$action="login";

	} else {

		$action = 'home';

	}

}

if ( $action == 'login' ){

	$PageLogin = new layout;

	echo $PageLogin->LoginForm();

} else if ( $action == 'contacts' ) {

	include("contacts.php");
	$ContForm = new Contacts;
	echo $ContForm->ShowContacts( );

} else if ( $action == 'sendsms' ) {

/*
        mail( 's1036392_sms@smsgw7.gsm.co.za', $_POST["cellnumbers"], $_POST["cellmessage"], "From:root@prdnagios1.sars.gov.za" );
        header( "Location: index.php?option=sms");
*/
	$sms_nr = $_POST["cellnumbers"];
	$sms_msg = $_POST["cellmessage"];
	`/usr/java/jre1.8.0_25/bin/java -jar /usr/bin/distSMS.jar -n $sms_nr -t "$sms_msg"`;
        header( "Location: index.php?option=sms");


} else if ( $action == 'sms' ) {

	include("sms.php");
	$SMSForm = new sms;

	echo $SMSForm->SMSForm();

} else if ( $action == 'delhost' ) {

 	include("config.php");

/* 	mysql_connect( $dbhost,$dbuser,$dbpasswd ) or die ("MySQL connect failed");
	mysql_select_db( $dbname ); * */
	$query = "delete from hosts where id='" . $_GET['hostid'] . "'";
	$result = $GLOBALS['conn']->query($query) or die('error in query');
	//$HostList = $result->fetch_assoc();
	
	header( "Location: index.php?option=servers&sort=IPAddress");

} else if ( $action == 'servers' ) {

	include("hosts.php");

	$PageHostsList = new hosts;

	echo $PageHostsList->ListHosts( $_GET['sort'] );

} else if ( $action == 'SaveHost' ) {
	
	include("hosts.php");

	$HostSaver = new hosts;

	if ( ! isset ( $_POST['decomm'] ) ) { $Decomm = '0'; } else { $Decomm = '1'; }
	if ( ! isset ( $_POST['register'] ) ) { $Register = '0'; } else { $Register = '1'; }
	if ( ! isset ( $_POST['ping'] ) ) { $Ping = '0'; } else { $Ping = '1'; }

	$HostSaved = $HostSaver->HostSave( $_POST['hostip'], $_POST['sysown'], $_POST['sysloc'], $_POST['sysos'], $_POST['sysenv'], $_POST['sysstat'], $_POST['remcons'], $_POST['syssnmp'], $_POST['hostid'], $_POST['datecreated'],$_POST['snmpport'],$Decomm,$Register,$Ping);

} else if ( $action == 'edithost' ) {

	include("hosts.php");

	$PageHostAdd = new hosts;

	echo $PageHostAdd->EditHost( $_GET['hostid'] );

} else if ( $action == 'home' ) {

/* 	echo "\t\t\t\t\t<table class='links-table'>\n";
	echo "\t\t\t\t\t\t<tr>\n\t\t\t\t\t\t\t<th class='hosts'>Useful links on the SARS network.</th>\n\t\t\t\t\t\t</tr>\n";
	echo "\t\t\t\t\t\t<tr>\n\t\t\t\t\t\t\t<td><a href='http://10.30.2.227/nagios/' target='_blank'>Brooklyn Nagios</a><br></td>\n\t\t\t\t\t\t</tr>\n";
	echo "\t\t\t\t\t\t<tr>\n\t\t\t\t\t\t\t<td><a href='http://10.30.2.227/cacti/' target='_blank'>Brooklyn Cacti</a><br></td>\n\t\t\t\t\t\t</tr>\n";
	echo "\t\t\t\t\t\t<tr>\n\t\t\t\t\t\t\t<td><a href='https://10.30.2.100/lnxwiki/index.php5/Main_Page' target='_blank'>Linux Wiki</a><br></td>\n\t\t\t\t\t\t</tr>\n";
	echo "\t\t\t\t\t\t<tr>\n\t\t\t\t\t\t\t<td><a href='http://10.30.2.238:1920/' target='_blank'>ITM portal</a><br></td>\n\t\t\t\t\t\t</tr>\n";
	echo "\t\t\t\t\t\t<tr>\n\t\t\t\t\t\t\t<td><a href='https://mobile.sars.gov.za/owa/' target='_blank'>Exchange Web Portal</a><br></td>\n\t\t\t\t\t\t</tr>\n";
	echo "\t\t\t\t\t\t<tr>\n\t\t\t\t\t\t\t<td><a href='http://ptaenrem02.sars.gov.za/arsys/shared/login.jsp?/arsys/home' target='_blank'>SARS Remedy</a><br></td>\n\t\t\t\t\t\t</tr>\n";
	echo "\t\t\t\t\t\t<tr>\n\t\t\t\t\t\t\t<td><a href='http://myportal/Pages/Default.aspx' target='_blank'>SARS Portal</a><br></td>\n\t\t\t\t\t\t</tr>\n";
	echo "\t\t\t\t\t\t<tr>\n\t\t\t\t\t\t\t<td><a href='http://www.google.com/' target='_blank'>Google</a><br></td>\n\t\t\t\t\t\t</tr>\n";
	echo "\t\t\t\t\t</table>\n"; */
	include("homeBanner.php");

} else if ( ( $action == 'users' ) & ( $_SESSION['userlevel'] > 3 ) ) {

	$PageUsers = new layout;

	echo $PageUsers->ShowUsers();

} else if ( ( $action == 'useredit' ) & ( $_SESSION['userlevel'] > 3 ) ) {

	$PageUserEdit = new layout;

	echo $PageUserEdit->EditUser( $_GET['user'] );

} else if ( ( $action == 'adduser' ) & ( $_SESSION['userlevel'] > 3 ) ) {

	$PageUserAdd = new layout;

	echo $PageUserAdd->EditUser( 0 );

} else if ( ( $action == 'SaveUser' ) & ( $_SESSION['userlevel'] > 3 ) ) {


	$Uid = $_POST['UID'];
	$UName = $_POST['UserName'];
	$UFName = $_POST['UserFullName'];
	$UMNum = $_POST['UserMobile'];
	$UEMail = $_POST['UserEmail'];
	$UType = $_POST['UserType'];
	$UPwd = $_POST['PassWD'];
	$UPwd1 = $_POST['UserPasswd1'];
	$UPwd2 = $_POST['UserPasswd2'];

	if ( $UPwd1 <> "" ) {
		if ( $UPwd1 == $UPwd2 ) {
			$NewPass = md5( $UPwd1 );
			if ( $Uid <> '0' ) {
				$PasswdWrite = mysqli_query($GLOBALS['conn'],"UPDATE users SET Password='$NewPass' WHERE id='$Uid'");
				header( "Location: index.php?option=users" );
			}
		} else {

			echo "<form action='index.php?option=users' method=post><center><p>The passwords do not seem to match.</p><center>\n";
			echo "<center><input type='submit' value='Continue'></center></form>";
			return;
		}
	}

	if ( $Uid == '0' ) {

		$UserWrite = mysqli_query("insert into users (UserName, FullName, MobilePhone, Email, Level, DateCreated, Password) values ( '$UName', '$UFName', '$UMNum', '$UEMail', '$UType', '" . date("Y-m-d H:i:s") . "', '" . $NewPass . "' );" ) or die ("Problems");

	} else {

		$UserWrite = mysqli_query("UPDATE users SET UserName='$UName',FullName='$UFName',MobilePhone='$UMNum',Email='$UEMail',Level='$UType' WHERE id='$Uid'");

	}

	header( "Location: index.php?option=users" );
	/* mysql_close(); */


} else if ( $action == 'logout' ) {
  
	$_SESSION['username']='Guest';
	session_start();
	session_unset();
	session_destroy();
	header( "Location: index.php" );

}

echo "\t\t\t<tr bgcolor='#6f98b7' style='padding: 5px; border: #183c8f 2px solid;'>\n";
echo "\t\t\t\t<td colspan='3' style='padding: 5px; border: #183c8f 2px solid;'>\n";
echo "\t\t\t\t\t<center>This site was hand rolled by Dave le Roux using a blend of four Open Source languages, updates done by Sakhile Sibuyi </center>\n";
echo "\t\t\t\t</td>\n";
echo "\t\t\t</tr>\n";
echo "\t\t</table>\n";
echo "\t</body>\n";
echo "</html>";
?>
