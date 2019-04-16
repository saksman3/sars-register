<?php
/*  include("config.php"); */
class Contacts
{

	function ShowContacts( )
	{

/* 		mysql_connect ( $dbhost, $dbuser, $dbpasswd ) or die ( "MySQL Connect Failed" );
		mysql_select_db( $dbname ); */

		$query = "select id,FullName,OfficePhone,MobilePhone,Email,Department from contacts order by FullName;";
        $ContactList = $GLOBALS['conn']->query($query);
		$NumRows = mysqli_num_rows( $ContactList );
		echo"<div class='container text-center'>
		<h2>Server Register</h2><h3>Contact Management Centre</h3>
		";
	
		echo "<table class='table table-striped table-bordered tab'>";
		echo "<tr>
				<th >Name</th>
				<th >Mobile</th>
				<th >Office</th>
				<th >Email</th>
				<th >Department</th>
			  </tr>";

		if ( $NumRows == 0 ) {

			echo "<h4>No Contacts defined in your database.</h4>";
		
		} else {


			while ($row=$ContactList->fetch_assoc() ) {
			 echo "<tr> <td>";
				if ( $_SESSION['userlevel'] > 2 ) {

					echo "<a href='index.php?option=ContShow&contid=".$row['id']."'>";

				}

				echo $row["FullName"];
				echo"</a></td>";
				echo "<td>" . $row["MobilePhone"] . "</td>";
				echo "<td>" . $row["OfficePhone"]. "</td>";
				echo "<td>" .$row["Email"]. "</td>";
				echo "<td>" . $row["Department"] . "</td></tr>";
				echo "</tr>";

			}

		}

		echo "</table>";
		echo"</div>";

	}

}

?>
