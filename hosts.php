<?php
include("config.php");
class hosts
{

	function ListHosts( $SortOrder )
	{
	     include("hostsList.php");  //moved all the code into a new file.
        

	}

	function EditHost( $HostID ) {
	   include("EditHosts.php");
	}

	function HostSave( $HostIP,$HostName, $SysOwn, $Location, $OS, $SysEnv, $Status, $RemCons, $SNMP, $HostID, $DateCreated, $SNMPPort, $Decomm, $Register, $Ping ) {

/* 		include("config.php");
		mysql_connect( $dbhost,$dbuser,$dbpasswd ) or die ("MySQL connect failed");
		mysql_select_db( $dbname ); */

		if ( ! isset ( $Decomm ) ) { $Decomm = '0'; }
		if ( ! isset ( $Register ) ) { $Decomm = '0'; }

		if ( $HostID == 0 ) {

			$OldHost = "select * from hosts where IPAddress='$HostIP';";
			$result = $GLOBALS['conn']->query($OldHost);
		
			$NumRows = mysqli_num_rows($result);
	
			

			if ( $NumRows > 0 ) {

			        echo "<form action='index.php?option=servers&sort=IPAddress' method=post><center><p>The host $HostIP is already defined in the database.</p><center>\n";
			        echo "<center><input type='submit' value='Continue'></center></form>";
				return;

			} else {

				$query = "insert into hosts (IPAddress,HostName, SysOwner, SysLocation, OS, SysEnvironment, Status, SysRemConsole, SysSNMP, DateCreated, SNMPPort, Decomm, Register, scan, ping ) values ( '$HostIP','$HostName','$SysOwn', '$Location', '$OS', '$SysEnv', '$Status', '$RemCons', '$SNMP', NOW(), $SNMPPort, $Decomm, $Register, '0', $Ping )";
				$HostRec=$GLOBALS['conn']->query($query) or die("error inserting data to db");
			}

		} else {

		
			

			$query = "select * from contacts where FullName = '$SysOwn'";
			$result = $GLOBALS['conn']->query($query);
			$OwnerRec = $result->fetch_assoc();

			$HostRec = mysqli_query($GLOBALS['conn'],"UPDATE hosts SET IPAddress='$HostIP',HostName='$HostName',SysOwner=$SysOwn,SysLocation=$Location,OS=$OS,SysEnvironment='$SysEnv',Status='$Status',SysRemConsole='$RemCons',SysSNMP='$SNMP',SNMPPort='$SNMPPort',Decomm='$Decomm',Register='$Register',ping=$Ping WHERE id='$HostID'");

			

		}

		//mysql_close();
		header( "Location: index.php?option=servers&sort=IPAddress" );

	}

	function HostDelete( $HostID ) {

		/* include("config.php"); */

              /*   mysql_connect( $dbhost,$dbuser,$dbpasswd ) or die ("MySQL connect failed");
                mysql_select_db( $dbname ); */
				$query = "delete from hosts where id='$HostID'";
				$result = $GLOBALS['conn']->query($query);
				 
                //mysql_close();
	}



}

?>
