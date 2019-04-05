<?php

class Contacts
{

	function ShowContacts( )
	{
	
		include("config.php");
		mysql_connect ( $dbhost, $dbuser, $dbpasswd ) or die ( "MySQL Connect Failed" );
		mysql_select_db( $dbname );

		$ContactList = mysql_query( "select id,FullName,OfficePhone,MobilePhone,Email,Department from contacts order by FullName;" );

		$NumRows = mysql_num_rows( $ContactList );

		echo "\t\t\t\t\t<table class='hosts'>\n";
		echo "\t\t\t\t\t\t<tr>\n";
		echo "\t\t\t\t\t\t\t<th class='hosts' colspan=5>\n";
		echo "\t\t\t\t\t\t\t\t<center><h2>Server Register</h2><h3>Contact Management Centre</h3></center>\n";
		echo "\t\t\t\t\t\t\t</th>\n";
		echo "\t\t\t\t\t\t</tr>\n";
		echo "\t\t\t\t\t\t<tr><th class='hosts'>Name</th><th class='hosts'>Mobile</th><th class='hosts'>Office</th><th class='hosts'>Email</th><th class='hosts'>Department</th></tr>\n";

		if ( $NumRows == 0 ) {

			echo "\t\t\t\t\t\t<h4>No Contacts defined in your database.</h4>\n";
		
		} else {

			$i = 0;
			$FlipFlop = true;

			while ( $i < mysql_num_rows( $ContactList ) ) {

				if ( $FlipFlop ) { echo "\t\t\t\t\t\t<tr bgcolor=#eeeeee>\n"; } else { echo "\t\t\t\t\t\t<tr bgcolor=#cccccc>\n"; }

				echo "\t\t\t\t\t\t\t<td>";
				if ( $_SESSION['userlevel'] > 2 ) {

					echo "<a href='index.php?option=ContShow&contid=".mysql_result( $ContactList, $i, 'id' )."'>";

				}

				echo mysql_result( $ContactList, $i, "FullName" );

				if ( $_SESSION['userlevel'] > 2 ) {

					echo "</a>";

				}
				echo "<td>" . mysql_result( $ContactList, $i, "MobilePhone" ) . "</td>";
				echo "<td>" . mysql_result( $ContactList, $i, "OfficePhone" ) . "</td>";
				echo "<td>" . mysql_result( $ContactList, $i, "Email" ) . "</td>";
				echo "<td>" . mysql_result( $ContactList, $i, "Department" ) . "</td></tr>\n";

				$i++;
				$FlipFlop = !$FlipFlop;
				echo "\t\t\t\t\t\t</tr>\n";

			}

		}

		echo "\t\t\t\t\t</table>\n";

	}

}

?>
