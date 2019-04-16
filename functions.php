<?php
  include("config.php");
class layout
{

	function Header( $TitleString )
	{
		/* The HTML page header is generated here. */
         include("header.php");
	}


	function LoginForm(){

		include("loginForm.php");

	}

	function ShowUsers(){

         $query = "select * from users";
		 $UserList = $GLOBALS['conn']->query($query);
		echo"<div class ='container text-center user-list'>

		<h2>Users registered on this system</h2>
		<p class='bg-info py-2'><a href='index.php?option=adduser'>Add a new user</a></p>

		";
	    echo"<table class='table table-bordered table-hover text-condensed table-striped'>
             <thead>
                <th >User name</th>
                <th >Full Name</th>
                <th >Mobile</th>
                <th >Email</th>
                <th >Type</th>
                <th >Date Created</th>
                <th >Last Login</th>
			 </thead>
			 <tbody>
			 ";
				 
			 while ( $row = $UserList->fetch_assoc()) {
			 echo"
			 <tr>
				 <td><a href='index.php?option=useredit&user=" . $row["id"] . "'>" . $row["UserName"]. "</a></td>
				 <td>" . $row["FullName"]. "</td>
				 <td>" . $row["MobilePhone"] . "</td>
				 <td>" . $row["Email"]. "</td>
				 <td>";
						if ( $row["Level"] == 2 ) {
							echo "Good Buddy";
						} else if ( $row["Level"] == 3 ) {
							echo "Team member";
						} else {
							echo "Uber Administrator";
						}
				echo"</td>
				   
				";
				echo"<td>" . $row["DateCreated"] . "</td>";
                echo"<td>" .$row["LastLogin"] . "</td>";
			echo" </tr>";
			 }
	       echo"</tbody> </table>
			 ";
	}

	function EditUser( $UserID ){
		echo"<div class='container edit-user'>";
		  
		if ( $UserID <> 0 ) {
            
			 $UserRecord ="select * from users where id='$UserID'";
			 $result = $GLOBALS['conn']->query($UserRecord);
			$UserInfo = $result->fetch_assoc();
			$UserName = $UserInfo['UserName'];
			$UserFullName = $UserInfo['FullName'];
			$UserMobile = $UserInfo['MobilePhone'];
			$UserEmail = $UserInfo['Email'];
			$UserType = $UserInfo['Level'];
			$UserPassword = $UserInfo['Password'];
			$UserPassword1 = "";
			$UserPassword2 = "";
			echo"<h4 class='text-center text-danger'>Editing user ".$UserName."</h4>";

		} else {

			$UserName = "";
			$UserFullName = "";
			$UserMobile = "";
			$UserEmail = "";
			$UserType = "1";
			$UserPassword = "";
			$UserPassword1 = "";
			$UserPassword2 = "";
			echo"<h4 class='text-center'>Add New user</h4>";

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
		echo"</div>";

	}

}
echo"</div>";
?>
