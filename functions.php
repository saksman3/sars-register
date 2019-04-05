<?php

class layout
{

	function Header( $TitleString )
	{
	
		/* The HTML page header is generated here. */
		echo "<html>\n";
		echo "\t<head>\n";
		echo "\t\t<title>$TitleString</title>\n";
		echo "\t\t<link href='styles/styles.css' rel='stylesheet' type='text/css'>\n";
		echo "\t\t<script language='javascript' type='text/javascript'>\n";
		echo "\t\tfunction limitText(limitField, limitCount, limitNum) {\n";
		echo "\t\t\tif (limitField.value.length > limitNum) {\n";
		echo "\t\t\t   limitField.value = limitField.value.substring(0, limitNum);\n";
		echo "\t\t\t} else {\n";
		echo "\t\t\t   limitCount.value = limitNum - limitField.value.length;\n";
		echo "\t\t\t}\n";
		echo "\t\t}\n";
		echo "\t\t</script>\n";
		echo "\t</head>\n";
		echo "\t<body leftmargin='0' topmargin='0' marginwidth='0' marginheight='0'>\n";
		echo "\t\t<table width='100%' cellspacing='0' cellpadding='0'>\n";
		echo "\t\t\t<tr height='37' bgcolor='#6f98b7'>\n";
		echo "\t\t\t\t<td valign='bottom' colspan='3' nowrap>\n";
		echo "\t\t\t\t\t<table width='100%' cellspacing='0' cellpadding='0'>\n";
		echo "\t\t\t\t\t\t<tr>\n";
		echo "\t\t\t\t\t\t\t<td align='middle' valign='middle'>\n";
		echo "\t\t\t\t\t\t\t\t<h1><b>$TitleString</b></h1>\n";
		echo "\t\t\t\t\t\t\t</td>\n";
		echo "\t\t\t\t\t\t\t<td align='right'>\n";
		echo "\t\t\t\t\t\t\t\t<img src='images/SARS-WebBanner-2.png' align='absmiddle'>\n";
		echo "\t\t\t\t\t\t\t</td>\n";
		echo "\t\t\t\t\t\t</tr>\n";
		echo "\t\t\t\t\t</table>\n";
		echo "\t\t\t\t</td>\n";
		echo "\t\t\t</tr>\n";
		echo "\t\t\t<tr style='background-color: #183c8f; height: 2px;'>\n";
		echo "\t\t\t\t<td colspan=3 style='background: #183c8f;'>\n";
		echo "\t\t\t\t\t<img src='images/blank.png'>\n";
		echo "\t\t\t\t</td>\n";
		echo "\t\t\t</tr>\n";
		echo "\t\t\t<tr height='5' bgcolor='#6f98b7'>\n";
		echo "\t\t\t\t<td colspan='3'>\n";
		echo "\t\t\t\t\t<table width='100%'>\n";
		echo "\t\t\t\t\t\t<tr>\n";
		echo "\t\t\t\t\t\t\t<td>\n";
		echo "\t\t\t\t\t\t\t\tGood day ".$_SESSION['userfullname']."\n";
		echo "\t\t\t\t\t\t\t</td>\n";
		echo "\t\t\t\t\t\t\t<td align='right'>\n";
		echo "\t\t\t\t\t\t\t\tYou look busy today!!\n";
		echo "\t\t\t\t\t\t\t</td>\n";
		echo "\t\t\t\t\t\t</tr>\n";
		echo "\t\t\t\t\t</table>\n";
		echo "\t\t\t\t</td>\n";
		echo "\t\t\t</tr>\n";
		echo "\t\t\t<tr style='background-color: #183c8f; height: 2px;'>\n";
		echo "\t\t\t\t<td colspan=3 style='background: #183c8f;'>\n";
		echo "\t\t\t\t\t<img src='images/blank.png'>\n";
		echo "\t\t\t\t</td>\n";
		echo "\t\t\t</tr>\n";
		echo "\t\t\t<tr>\n";
		echo "\t\t\t\t<td valign='top' colspan='1' rowspan='2' width='10%' style='padding: 5px; border-right: #183c8f 2px solid;'>\n";
		echo "\t\t\t\t\t<table cellpadding='3' cellspacing='0' border='0' width='100%'>\n";
		echo "\t\t\t\t\t\t<tr>\n";
		echo "\t\t\t\t\t\t\t<td>\n";
		echo "\t\t\t\t\t\t\t\t<a href='index.php?option=links'>Useful links</a>\n";
		echo "\t\t\t\t\t\t\t</td>\n";
		echo "\t\t\t\t\t\t</tr>\n";
		echo "\t\t\t\t\t\t<tr>\n";
		echo "\t\t\t\t\t\t\t<td>\n";
		echo "\t\t\t\t\t\t\t\t<a href='index.php?option=sms'>SMS Despatcher</a>\n";
		echo "\t\t\t\t\t\t\t</td>\n";
		echo "\t\t\t\t\t\t</tr>\n";
		echo "\t\t\t\t\t\t<tr>\n";
		echo "\t\t\t\t\t\t\t<td>\n";
		echo "\t\t\t\t\t\t\t\t<a href='index.php?option=servers&sort=IPAddress'>Server Register</a>\n";
		echo "\t\t\t\t\t\t\t</td>\n";
		echo "\t\t\t\t\t\t</tr>\n";

		if ( $_SESSION['userlevel'] > 3 ) {
			echo "\t\t\t\t\t\t<tr>\n";
			echo "\t\t\t\t\t\t\t<td>\n";
			echo "\t\t\t\t\t\t\t\t<a href='index.php?option=contacts'>Server Contacts</a>\n";
			echo "\t\t\t\t\t\t\t</td>\n";
			echo "\t\t\t\t\t\t</tr>\n";
			echo "\t\t\t\t\t\t<tr>\n";
			echo "\t\t\t\t\t\t\t<td>\n";
			echo "\t\t\t\t\t\t\t\t<a href='index.php?option=users'>Register Users</a>\n";
			echo "\t\t\t\t\t\t\t</td>\n";
			echo "\t\t\t\t\t\t</tr>\n";
		}
		if ( $_SESSION['username'] == "Guest" ) {
			echo "\t\t\t\t\t\t<tr>\n";
			echo "\t\t\t\t\t\t\t<td>\n";
			echo "\t\t\t\t\t\t\t\t<a href='index.php?option=login'>Login</a>\n";
			echo "\t\t\t\t\t\t\t</td>\n";
			echo "\t\t\t\t\t\t</tr>\n";
		} else {
			echo "\t\t\t\t\t\t<tr>\n";
			echo "\t\t\t\t\t\t\t<td>\n";
			echo "\t\t\t\t\t\t\t\t<a href='index.php?option=logout'>Logout</a>\n";
			echo "\t\t\t\t\t\t\t</td>\n";
			echo "\t\t\t\t\t\t</tr>\n";
		}
		echo "\t\t\t\t\t</table>\n";
		echo "\t\t\t\t</td>\n";
		echo "\t\t\t</tr>\n";
		echo "\t\t\t<tr>\n";
		echo "\t\t\t\t<td width='100%' colspan='2' valign='top' style='padding: 5px; border-right: #aaaaaa 1px solid;'>\n";
	}


	function LoginForm(){

		echo "\t\t\t\t\t<h1>Login page</h1>\n";
		if ( $_SESSION['failed'] ) {
			echo "\t\t\t\t\t<p>Your login attempt failed, please try again.</p>";
		}
		echo "\t\t\t\t\t<form id='form1' name='form1' method='post' action='$_SERVER[PHP_SELF]'>\n";
		echo "\t\t\t\t\t\t<table>\n";
		echo "\t\t\t\t\t\t\t<tr>\n";
		echo "\t\t\t\t\t\t\t\t<td>User : </td>\n";
		echo "\t\t\t\t\t\t\t\t<td><input name='username' type='text' id='username' /></td>\n";
		echo "\t\t\t\t\t\t\t</tr>\n";
		echo "\t\t\t\t\t\t\t<tr>\n";
		echo "\t\t\t\t\t\t\t\t<td>Password : </td>\n";
		echo "\t\t\t\t\t\t\t\t<td><input name='password' type='password' id='password' /></td>\n";
		echo "\t\t\t\t\t\t\t</tr>\n";
		echo "\t\t\t\t\t\t</table>\n";
		echo "\t\t\t\t\t\t<input name='Login' type='submit' id='Login' value='Login' />\n";
		echo "\t\t\t\t\t</form>\n";

	}

	function ShowUsers(){

		include("config.php");
	        mysql_connect( $dbhost,$dbuser,$dbpasswd ) or die ("MySQL connect failed");
	        mysql_select_db( $dbname );
 		$UserList = mysql_query( "select * from users ");
		mysql_close();

		echo "\t\t\t\t\t<p><a href='index.php?option=adduser'>Add a new user</a></p>\n";
		echo "\t\t\t\t\t<table class='user'>\n";
		echo "\t\t\t\t\t\t<tr class='user'>\n";
		echo "\t\t\t\t\t\t\t<th class='user' colspan=7>\n";
		echo "\t\t\t\t\t\t\t\tUsers registered on this system\n";
		echo "\t\t\t\t\t\t\t</th>\n";
		echo "\t\t\t\t\t\t</tr>\n";
		echo "\t\t\t\t\t\t<tr class='user'>\n";
		echo "\t\t\t\t\t\t\t<th class='user'>\n";
		echo "\t\t\t\t\t\t\t\tUser name\n";
		echo "\t\t\t\t\t\t\t</th>\n";
		echo "\t\t\t\t\t\t\t<th class='user'>\n";
		echo "\t\t\t\t\t\t\t\tFull Name\n";
		echo "\t\t\t\t\t\t\t</th>\n";
		echo "\t\t\t\t\t\t\t<th class='user'>\n";
		echo "\t\t\t\t\t\t\t\tMobile\n";
		echo "\t\t\t\t\t\t\t</th>\n";
		echo "\t\t\t\t\t\t\t<th class='user'>\n";
		echo "\t\t\t\t\t\t\t\tEmail\n";
		echo "\t\t\t\t\t\t\t</th>\n";
		echo "\t\t\t\t\t\t\t<th class='user'>\n";
		echo "\t\t\t\t\t\t\t\tType\n";
		echo "\t\t\t\t\t\t\t</th>\n";
		echo "\t\t\t\t\t\t\t<th class='user'>\n";
		echo "\t\t\t\t\t\t\t\tDate Created\n";
		echo "\t\t\t\t\t\t\t</th>\n";
		echo "\t\t\t\t\t\t\t<th class='user'>\n";
		echo "\t\t\t\t\t\t\t\tLast Login\n";
		echo "\t\t\t\t\t\t\t</th>\n";
		echo "\t\t\t\t\t\t</tr>\n";

		$FlipFlop = false;

		$i = 0;

		while ( $i < mysql_num_rows( $UserList ) ) {
			if ( $FlipFlop ) {
				echo "\t\t\t\t\t\t<tr bgcolor=#cccccc>\n";
			} else {
				echo "\t\t\t\t\t\t<tr bgcolor=#eeeeee>\n";
			}

			echo "\t\t\t\t\t\t\t<td class='user'>\n\t\t\t\t\t\t\t\t<a href='index.php?option=useredit&user=" . mysql_result( $UserList, $i, "id" ) . "'>" . mysql_result( $UserList, $i, "UserName" ) . "</a>\n\t\t\t\t\t\t\t</td>\n";
			echo "\t\t\t\t\t\t\t<td class='user'>\n\t\t\t\t\t\t\t\t" . mysql_result( $UserList, $i, "FullName" ) . "\n\t\t\t\t\t\t\t</td>\n";
			echo "\t\t\t\t\t\t\t<td class='user'>\n\t\t\t\t\t\t\t\t" . mysql_result( $UserList, $i, "MobilePhone" ) . "\n\t\t\t\t\t\t\t</td>\n";
			echo "\t\t\t\t\t\t\t<td class='user'>\n\t\t\t\t\t\t\t\t" . mysql_result( $UserList, $i, "Email" ) . "\n\t\t\t\t\t\t\t</td>\n";
			echo "\t\t\t\t\t\t\t<td class='user'>\n";
			if ( mysql_result( $UserList, $i, "Level" ) == 2 ) {
				echo "\t\t\t\t\t\t\t\tGood Buddy\n";
			} else if ( mysql_result( $UserList, $i, "Level" ) == 3 ) {
				echo "\t\t\t\t\t\t\t\tTeam member\n";
			} else {
				echo "\t\t\t\t\t\t\t\tUber Administrator\n";
			}
			echo "\t\t\t\t\t\t\t</td>\n";
			echo "\t\t\t\t\t\t\t<td class='user'>\n\t\t\t\t\t\t\t\t" . mysql_result( $UserList, $i, "DateCreated" ) . "\n\t\t\t\t\t\t\t</td>\n";
			echo "\t\t\t\t\t\t\t<td class='user'>\n\t\t\t\t\t\t\t\t" . mysql_result( $UserList, $i, "LastLogin" ) . "\n\t\t\t\t\t\t\t</td>\n";
			$FlipFlop = !$FlipFlop;
			$i++;
			echo "\t\t\t\t\t\t</tr>\n";
		}

		echo "\t\t\t\t\t</table>\n";

	}

	function EditUser( $UserID ){

		if ( $UserID <> 0 ) {

			include("config.php");
		        mysql_connect( $dbhost,$dbuser,$dbpasswd ) or die ("MySQL connect failed");
		        mysql_select_db( $dbname );
	 		$UserRecord = mysql_query( "select * from users where id='$UserID'") or die("Bad news dude");
			mysql_close();
			$UserInfo = mysql_fetch_row( $UserRecord );
	
			$UserName = $UserInfo[1];
			$UserFullName = $UserInfo[2];
			$UserMobile = $UserInfo[3];
			$UserEmail = $UserInfo[4];
			$UserType = $UserInfo[5];
			$UserPassword = $UserInfo[8];
			$UserPassword1 = "";
			$UserPassword2 = "";

		} else {

			$UserName = "";
			$UserFullName = "";
			$UserMobile = "";
			$UserEmail = "";
			$UserType = "1";
			$UserPassword = "";
			$UserPassword1 = "";
			$UserPassword2 = "";

		}

		echo "<form action='index.php?option=SaveUser' method=post>";
		echo "<table class=user><tr class=user><th class='user' colspan=2>Edit registered system user.</th></tr>";
		echo "<input type=hidden name='UID' value=$UserID>";
		echo "<input type=hidden name='PassWD' value=$UserPassword>";
		if ( $UserID == 1 ) {

			echo "<tr class=user><th class=user>User Name</th><td class=user>$UserName</td></tr>"; 
			echo "<input type=hidden name='UserName' value='admin'>"; 

		} else {

			echo "<tr class=user><th class=user>User Name</th><td class=user><input type=text name='UserName' value=$UserName></td></tr>"; 

		}

		echo "<tr class=user><th class=user>Full Name</th><td class=user><input type=text name='UserFullName' value='$UserFullName'></td></tr>"; 
		echo "<tr class=user><th class=user>Mobile Phone Number</th><td class=user><input type=text name='UserMobile' value='$UserMobile'></td></tr>"; 
		echo "<tr class=user><th class=user>Email Address</th><td class=user><input type=text name='UserEmail' value=$UserEmail></td></tr>"; 
		echo "<tr class=user>\n\t<th class=user>User Type</th>\n<td class=user>";
		if ( $UserID <> 1 ) {
			echo "\t\t<select name='UserType'>\n";
			echo "<option ";
			echo ( $UserType == 2 ) ? ' selected': '';
			echo " value='2'>Good Buddy.";
			echo "<option ";
			echo ( $UserType == 3 ) ? ' selected': '';
			echo " value='3'>Team member.";
			echo "<option ";
			echo ( $UserType == 4 ) ? ' selected': '';
			echo " value='4'>Uber Administrator!!";
			echo "</select>";
		} else {
			echo "Uber Administrator!!";
			echo "<input type=hidden name='UserType' value=4>";
		}
		echo "</td></tr>"; 
		echo "<tr class=user><th class=user>Password</th><td class=user><input type=password name='UserPasswd1' value=$UserPassword1></td></tr>"; 
		echo "<tr class=user><th class=user>Password Again</th><td class=user><input type=password name='UserPasswd2' value=$UserPassword2></td></tr>"; 
		echo "</table>";
		echo "<center><input type='submit' value='Save'></center>";
		echo "</form>";

	}

}

?>
