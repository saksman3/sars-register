<?php

class hosts
{

	function ListHosts( $SortOrder )
	{
	
		$HostStates = array( "Host is Fine", "Host is down", "SNMP Broken", "Registered only" );

		echo "\t\t\t\t\t<table class='hosts'>\n\t\t\t\t\t\t<tr>\n\t\t\t\t\t\t\t<th class='hosts' colspan=10>\n\t\t\t\t\t\t\t\t<center>\n\t\t\t\t\t\t\t\t\tSARS Server Register\n\t\t\t\t\t\t\t\t</center>\n\t\t\t\t\t\t\t</th>\n\t\t\t\t\t\t</tr>\n";

                if ( $_SESSION['userlevel'] > 2 ) {

                        echo "\t\t\t\t\t\t<tr>\n\t\t\t\t\t\t\t<th class='hosts' colspan=10>\n\t\t\t\t\t\t\t\t<center>\n\t\t\t\t\t\t\t\t\t<a href='index.php?option=edithost&hostid=0'>\n\t\t\t\t\t\t\t\t\t\tAdd a new server\n\t\t\t\t\t\t\t\t\t</a>\n\t\t\t\t\t\t\t\t</center>\n\t\t\t\t\t\t\t</th>\n\t\t\t\t\t\t</tr>\n";

                }

		echo "\t\t\t\t\t\t<tr>\n\t\t\t\t\t\t\t<th class='hosts'>\n\t\t\t\t\t\t\t\t<a href='index.php?option=servers&sort=HostName'>Host Name</a>\n\t\t\t\t\t\t\t</th>\n\t\t\t\t\t\t\t<th class='hosts'>\n\t\t\t\t\t\t\t\t<a href='index.php?option=servers&sort=IPAddress'>Host IP</a>\n\t\t\t\t\t\t\t</th>\n\t\t\t\t\t\t\t<th class='hosts'>\n\t\t\t\t\t\t\t\t<a href='index.php?option=servers&sort=contacts.FullName,HostName'>System Owner</a>\n\t\t\t\t\t\t\t</th>\n\t\t\t\t\t\t\t<th class='hosts'>\n\t\t\t\t\t\t\t\t<a href='index.php?option=servers&sort=locations.LocName,HostName'>Location</a>\n\t\t\t\t\t\t\t</th>\n\t\t\t\t\t\t\t<th class='hosts'>\n\t\t\t\t\t\t\t\t<a href='index.php?option=servers&sort=environments.EnvName,HostName'>Environment</a>\n\t\t\t\t\t\t\t</th>\n\t\t\t\t\t\t\t<th class='hosts'>\n\t\t\t\t\t\t\t\t<a href='index.php?option=servers&sort=status.FullName,HostName'>Status</a>\n\t\t\t\t\t\t\t</th>\n\t\t\t\t\t\t\t<th class='hosts'>\n\t\t\t\t\t\t\t\t<a href='index.php?option=servers&sort=oses.OSName,HostName'>OS Type</a>\n\t\t\t\t\t\t\t</th>\n\t\t\t\t\t\t\t<th class='hosts'>\n\t\t\t\t\t\t\t\tRemote Console\n\t\t\t\t\t\t\t</th>\n\t\t\t\t\t\t\t<th class='hosts'>\n\t\t\t\t\t\t\t\tServer State\n\t\t\t\t\t\t\t</th>\n\t\t\t\t\t\t\t<th class='hosts'>\n\t\t\t\t\t\t\t\tAction\n\t\t\t\t\t\t\t</th>\n\t\t\t\t\t\t</tr>\n";

		include("config.php");

                mysql_connect( $dbhost,$dbuser,$dbpasswd ) or die ("MySQL connect failed");
                mysql_select_db( $dbname );
                $HostList = mysql_query( "select hosts.id,HostName,IPAddress,contacts.FullName,locations.LocName,environments.EnvName,status.FullName,scan,oses.OSName,SysRemConsole,Decomm,Register from hosts,contacts,locations,environments,status,oses where hosts.SysOwner=contacts.id and hosts.SysLocation=locations.id and hosts.SysEnvironment=environments.id and hosts.Status=status.id and hosts.OS=oses.id order by $SortOrder ASC");

		$NumRows = mysql_numrows( $HostList );

		if ( $NumRows == 0) {

			echo "\t\t\t\t\t\t<tr>\n\t\t\t\t\t\t\t<th class='hosts' colspan=6>\n\t\t\t\t\t\t\t\t<center>No hosts have been defined in your database.</center>\n\t\t\t\t\t\t\t</th>\n\t\t\t\t\t\t</tr>\n";

		} else {

			$i = 0;
			$FlipFlop = true;
			$HostContact = new hosts;

			

			while ( $i < mysql_num_rows( $HostList ) ) {

				$HostID = mysql_result( $HostList, $i, "hosts.id" );
				$ContactID = mysql_result( $HostList, $i, 'contacts.FullName' );

				if ( $FlipFlop ) { echo "\t\t\t\t\t\t<tr bgcolor=#eeeeee>\n"; } else { echo "\t\t\t\t\t\t<tr bgcolor=#cccccc>\n"; }

				echo "\t\t\t\t\t\t\t<td>\n";
				echo "\t\t\t\t\t\t\t\t<a href='index.php?option=edithost&hostid=$HostID'>".mysql_result( $HostList, $i, "HostName" )."</a>\n";
				echo "\t\t\t\t\t\t\t</td>\n";
				echo "\t\t\t\t\t\t\t<td>\n";
				echo "\t\t\t\t\t\t\t\t<a href='index.php?option=edithost&hostid=$HostID'>" . mysql_result( $HostList, $i, "IPAddress" ) . "</a>\n";
				echo "\t\t\t\t\t\t\t</td>\n";
				echo "\t\t\t\t\t\t\t<td>\n\t\t\t\t\t\t\t\t" . mysql_result( $HostList, $i, "contacts.FullName" ) . "\n\t\t\t\t\t\t\t</td>\n";
				echo "\t\t\t\t\t\t\t<td>\n\t\t\t\t\t\t\t\t" . mysql_result( $HostList, $i, "locations.LocName" ) . "\n\t\t\t\t\t\t\t</td>\n";
				echo "\t\t\t\t\t\t\t<td>\n\t\t\t\t\t\t\t\t" . mysql_result( $HostList, $i, "environments.EnvName" ) . "\n\t\t\t\t\t\t\t</td>\n";
				echo "\t\t\t\t\t\t\t<td>\n\t\t\t\t\t\t\t\t" . mysql_result( $HostList, $i, "status.FullName" ) . "\n\t\t\t\t\t\t\t</td>\n";
				echo "\t\t\t\t\t\t\t<td>\n\t\t\t\t\t\t\t\t" . mysql_result( $HostList, $i, "oses.OSName" ) . "\n\t\t\t\t\t\t\t</td>\n";
				if ( stristr ( mysql_result( $HostList, $i, "SysRemConsole" ), "http" ) ) {
					echo "\t\t\t\t\t\t\t<td>\n\t\t\t\t\t\t\t\t<a href='" . mysql_result( $HostList, $i, "SysRemConsole" ) . "' target=_blank>" . mysql_result( $HostList, $i, "SysRemConsole" ) . "</a>\n\t\t\t\t\t\t\t</td>\n";
				} else {
					echo "\t\t\t\t\t\t\t<td>\n\t\t\t\t\t\t\t\t" . mysql_result( $HostList, $i, "SysRemConsole" ) . "\n\t\t\t\t\t\t\t</td>\n";
				}



				if ( mysql_result( $HostList, $i, "Register" ) ) { 
					echo "\t\t\t\t\t\t\t<td style='background-color: orange;'>\n\t\t\t\t\t\t\t\tRegistered only\n\t\t\t\t\t\t\t</td>\n";
				} else if ( mysql_result( $HostList, $i, "Decomm" ) ) { 
					echo "\t\t\t\t\t\t\t<td style='background-color: orange;'>\n\t\t\t\t\t\t\t\tDecommissioned\n\t\t\t\t\t\t\t</td>\n"; 
				} else {
					echo "\t\t\t\t\t\t\t<td " . ((mysql_result( $HostList, $i, 'scan' ) == '0') ? "" : "style='background-color: orange;'") . ">\n\t\t\t\t\t\t\t\t" . $HostStates[ mysql_result( $HostList, $i, "scan" ) ] . "\n\t\t\t\t\t\t\t</td>\n";
				}

				if ( $_SESSION['userlevel'] > 2 ) {
					echo "\t\t\t\t\t\t\t<td>\n\t\t\t\t\t\t\t\t<a href=index.php?option=delhost&hostid=$HostID>Del</a>\n\t\t\t\t\t\t\t</td>\n";
				} else {
					echo "\t\t\t\t\t\t\t<td>\n\t\t\t\t\t\t\t\tNone\n\t\t\t\t\t\t\t</td>\n";
				}
				echo "\t\t\t\t\t\t</tr>\n";
				$i++;
				$FlipFlop = !$FlipFlop;
			}
		}

                mysql_close();

		echo "\t\t\t\t\t\t<tr>\n\t\t\t\t\t\t\t<th class='hosts' colspan=10 >\n\t\t\t\t\t\t\t\t<p>Please click on the Host name or IP Address to see more detail about the host.</p>\n\t\t\t\t\t\t\t\t<p>Click on the column heading to sort the hosts.</p>\n\t\t\t\t\t\t\t</th>\n\t\t\t\t\t\t</tr>\n";

		if ( $_SESSION['userlevel'] > 2 ) {

			echo "\t\t\t\t\t\t<tr>\n\t\t\t\t\t\t\t<th class='hosts' colspan=10>\n\t\t\t\t\t\t\t\t<center><a href='index.php?option=edithost&hostid=0'>Add a new server</a></center>\n\t\t\t\t\t\t\t</th>\n\t\t\t\t\t\t</tr>\n";

		}

		echo "\t\t\t\t\t</table>\n";

	}

	function EditHost( $HostID ) {

        	include("config.php");
		mysql_connect( $dbhost,$dbuser,$dbpasswd ) or die ("MySQL connect failed");
		mysql_select_db( $dbname );

		if ( $HostID == 0 ) {
			$IPAddress = "";
			$ContactName = "";
			$LocID = 0;
			$OS = 0;
			$Environment = "";
			$Status = "";
			$RemCons = "";
			$SNMP = "public";
			$SNMPPort = 161;
			$Decomm = 0;
			$Register = 0;
			$Ping = 1;
			$DateCreated = date("Y-m-d H:i:s");
			echo "<center>\n<p>I hope the server you are adding is currently up, and SNMP is enabled, or I will have to become aggressive when the server checks happen.</p>\n<p> \"Gentlemen, failure is not an option!\"</p>\n<p>A little magic you may wish to know. I do not like duplicates. You give me something I already know, I will quietly just throw it away. Because I am polite.</p></center>\n";

		} else {
			$HostList = mysql_query( "select IPAddress,HostName,contacts.FullName,SysLocation,OS,SysEnvironment,status.FullName,SysRemConsole,SysSNMP,hosts.DateCreated,contacts.MobilePhone,contacts.OfficePhone,contacts.ExtraPhone,contacts.Email,locations.LocName,environments.EnvName,oses.OSName,Platform,SysVersion,DateScanned,Memory,Router,Decomm,Register,SNMPPort,CPUCores,CPUModel,ping from hosts,contacts,locations,environments,status,oses where hosts.id = $HostID and SysOwner=contacts.id and SysLocation=locations.id and SysEnvironment=environments.id and status=status.id and OS=oses.id" ) or die( mysql_error() );

			$HostRec = mysql_fetch_row( $HostList );
			$FuncContact = new hosts;

			$IPAddress = $HostRec[0];
			$HostName = $HostRec[1];
			$ContactName = $HostRec[2];
			$LocID = $HostRec[3];
			$OS = $HostRec[4];
			$Environment = $HostRec[5];
			$Status = $HostRec[6];
			$RemCons = $HostRec[7];
			$SNMP = $HostRec[8];
			$DateCreated = $HostRec[9];
			$ContactMobile = $HostRec[10];
			$ContactOffice = $HostRec[11];
			$ContactExtraPhone = $HostRec[12];
			$ContactEmail = $HostRec[13]; 
			$LocationName = $HostRec[14];
			$EnvName = $HostRec[15];
			$OSType = $HostRec[16];
			$Platform = $HostRec[17];
			$Version = $HostRec[18];
			$DateScan = $HostRec[19];
			$Memory = $HostRec[20];
			if ( $HostRec[21]==2 ) { $Routing = 'Disabled'; } else { $Routing = 'Enabled'; }
			$Decomm=$HostRec[22];
			$Register=$HostRec[23];
			$SNMPPort=$HostRec[24];
			$CPUCores=$HostRec[25];
			$CPUModel=$HostRec[26];
			$Ping=$HostRec[27];
			
		}	

		if ( $_SESSION['userlevel'] > 2 ) {
			echo "\t\t\t\t\t<form action='index.php?option=SaveHost' method=post>\n";
			echo "\t\t\t\t\t\t<input type=hidden name='hostid' value=$HostID>\n";
			echo "\t\t\t\t\t\t<input type=hidden name='datecreated' value=$DateCreated>\n";
			echo "\t\t\t\t\t\t<table class=hosts><tr>\n";
			if ( $HostID > 0 ) { 
				echo "\t\t\t\t\t\t\t<input type=hidden name='hostip' value=$IPAddress>\n";
				echo "\t\t\t\t\t\t\t<tr>\n\t\t\t\t\t\t\t\t<th class='hosts'>Host IP Address</th><td class='hosts'>$IPAddress</td></tr>\n";
				echo "<tr><th class='hosts'>Host Name</th><td class='hosts'>$HostName</td></tr>\n";
			} else {

				echo "<tr><th class='hosts'>Host IP Address</th><td class='hosts'><input type=text name='hostip' value=$IPAddress></td></tr>\n";
			}
			echo "<tr><th class='hosts'>Server owner</th><td class='hosts'><select name=sysown>\n";

			$Contacts = mysql_query( "Select id,FullName from contacts order by FullName");
			$i = 0;
			while ( $i < mysql_num_rows( $Contacts ) ) {

				$Contact = mysql_result( $Contacts, $i, 'FullName' );
				echo "<option";
				if ( mysql_result( $Contacts, $i, 'FullName') == $ContactName ) {
					echo " selected";
				}
				echo " value='" . mysql_result( $Contacts, $i, 'id' ) . "'>$Contact\n";
				$i++;
			}

			echo "</select></td></tr>\n";
			echo "<tr><th class='hosts'>Server Location</th>\n<td class='hosts'>\n<select name=sysloc>\n";

			$Locations = mysql_query( "select id,LocName from locations order by LocName" );
			$i = 0;
			while ( $i < mysql_num_rows( $Locations ) ) {

				$Location = mysql_result( $Locations, $i, "LocName" );
				echo "<option";
				if ( mysql_result( $Locations, $i, "id" ) == $LocID ) {
					echo " selected";
				}
				echo " value='" . mysql_result( $Locations, $i, 'id' ) . "'>$Location\n";
				$i++;

			}

			echo "</select></td></tr>\n";

			echo "<tr><th class='hosts'>Server Operating System</th>\n<td class='hosts'>\n<select name=sysos>\n";

			$SysOSes = mysql_query( "select id,OSName from oses order by OSName" );
			$i = 0;
			while ( $i < mysql_num_rows( $SysOSes ) ) {

				$SysOS = mysql_result( $SysOSes, $i, "OSName" );
				echo "<option";
				if ( mysql_result( $SysOSes, $i, "id" ) == $OS ) {
					echo " selected";
				}
				echo " value='" . mysql_result( $SysOSes, $i, 'id' ) . "'>$SysOS\n";
				$i++;

			}

			echo "</select></td></tr>\n";

			echo "<tr><th class='hosts'>Server Environment</th>\n<td class='hosts'>\n<select name=sysenv>\n";
			$Environments = mysql_query( "select id,EnvName from environments order by EnvName" );
			$i = 0;
			while ( $i < mysql_num_rows( $Environments ) ) {

				$Env = mysql_result( $Environments, $i, "EnvName" );
				echo "<option";
				if ( mysql_result( $Environments, $i, "id" ) == $Environment ) {
					echo " selected";
				}
				echo " value='" . mysql_result( $Environments, $i, 'id' ) . "'>$Env\n";
				$i++;

			}

			echo "</select></td></tr>\n";

			echo "<tr><th class='hosts'>Server Status</th>\n<td class='hosts'>\n<select name=sysstat>\n";
			$Statuses = mysql_query( "select id,FullName from status order by FullName" );
			$i = 0;
			while ( $i < mysql_num_rows( $Statuses ) ) {

				$Stat = mysql_result( $Statuses, $i, "FullName" );
				echo "<option";
				if ( mysql_result( $Statuses, $i, "FullName" ) == $Status ) {
					echo " selected";
				}
				echo " value='" . mysql_result( $Statuses, $i, 'id' ) . "'>$Stat\n";
				$i++;

			}

			echo "</select></td></tr>\n";


			echo "<tr><th class='hosts'>Remote Console</th><td class='hosts'><input type=text name='remcons' value=$RemCons></td></tr>\n";
			echo "<tr><th class='hosts'>Only show in register (No Scans will be done)</th><td class='hosts'><input type='checkbox' name='register' value='1' ".(($Register)?' checked':'')."></td></tr>\n";
			echo "<tr><th class='hosts'>Decommission Host</th><td class='hosts'><input type='checkbox' name='decomm' value='1' ".(($Decomm)?' checked':'')."></td></tr>\n";
			echo "<tr><th class='hosts'>Can this host be pinged</th><td class='hosts'><input type='checkbox' name='ping' value='1' ".(($Ping)?' checked':'')."></td></tr>\n";
			echo "<tr><th class='hosts'>SNMP Community String</th><td class='hosts'><input type=text name='syssnmp' value=$SNMP></td></tr>\n";
			echo "<tr><th class='hosts'>SNMP Port</th><td class='hosts'><input type=text name='snmpport' value=$SNMPPort></td></tr>\n";
			echo "<tr><th class='hosts'>Date Created</th><td>$DateCreated</td></tr>";
			echo "<tr><td colspan=2><center><input type='submit' value='Save'></center></td></tr>";

		}

		if ( $HostID <> 0 ) {
			echo "<table class=hosts><tr>";
			echo "<tr><th class='hosts' colspan=2><h1>$HostName ($IPAddress)</h1></th></tr>";
			echo "<tr><th class='hosts'>Host IP Address</th><td class='hosts'>$IPAddress</td></tr>";
			echo "<tr><th class='hosts'>Host Name</th><td class='hosts'>$HostName</td></tr>";
			echo "<tr><th class='hosts'>Server owner</th><td class='hosts'>$ContactName</td></tr>";
			echo "<tr><th class='hosts'>Owner Mobile Phone</th><td class='hosts'>$ContactMobile</td></tr>";
			echo "<tr><th class='hosts'>Owner Office Phone</th><td class='hosts'>$ContactOffice</td></tr>";
			echo "<tr><th class='hosts'>Owner Extra Phone</th><td class='hosts'>$ContactExtraPhone</td></tr>";
			echo "<tr><th class='hosts'>Owner Email Address</th><td class='hosts'>$ContactEmail</td></tr>";
			echo "<tr><th class='hosts'>Server Location</th><td class='hosts'>$LocationName</td></tr>";
			echo "<tr><th class='hosts'>Server Operating System</th><td class='hosts'>$OSType</td></tr>";
			echo "<tr><th class='hosts'>Server Environment</th><td class='hosts'>$EnvName</td></tr>";
			echo "<tr><th class='hosts'>Server Status</th><td class='hosts'>$Status</td></tr>";
			echo "<tr><th class='hosts'>Server Remote Console</th><td class='hosts'><a href='$RemCons' target=_blank>$RemCons</a></td></tr>";
			echo "<tr><th class='hosts'>Only show in register (No Scans will be done)</th><td class='hosts'>".(($Register)?'Yes':'No')."</td></tr>\n";
			echo "<tr><th class='hosts'>Decommission Host</th><td class='hosts'>".(($Decomm)?'Yes':'No')."</td></tr>\n";
			echo "<tr><th class='hosts'>Can this host be pinged</th><td class='hosts'>".(($Ping)?'Yes':'No')."</td></tr>\n";
			echo "<tr><th class='hosts'>Kernel version</th><td class='hosts'>$Version</td></tr>";
			echo "<tr><th class='hosts'>Platform version</th><td class='hosts'>$Platform</td></tr>";
			echo "<tr><th class='hosts'>Date Created</th><td>$DateCreated</td></tr>";
			echo "<tr><th class='hosts'>Last successful scan</th><td>$DateScan</td></tr>";
			echo "</table><br>";

			########################################################################################
			# Hardware information

			echo "<table class=hosts>";
			echo "<tr><th class=hosts colspan=2><h2>Hardware configuration</h2></td></tr>";
			echo "<tr><th class=hosts>Item</th><th class=hosts>Information</th></tr>";
			echo "<tr><th class=hosts>Physical Memory (MB)</th><td class=hosts>".number_format($Memory)."</td></tr>";
			echo "<tr><th class=hosts>CPU Model</th><td class=hosts>$CPUModel</td></tr>";
			echo "<tr><th class=hosts>CPU Cores</th><td class=hosts>$CPUCores</td></tr>";
			echo "</table><br>";
			
			

			########################################################################################
			# Network Information ..
			echo "<table class=hosts>";
			echo "<tr><th class=hosts colspan=2><h2>Network configuration</h2></td></tr>";
			echo "<tr><th class=hosts>Routing enabled?</td><td class=hosts>".$Routing."</td></tr>";
			echo "</table>";
			echo "<table class=hosts>";
			echo "<tr><th class=hosts colspan=5><h3>Interfaces</h3></th></tr>";
			echo "<tr><th class=hosts>Interface</th><th class=hosts>IP Address</th><th class=hosts>Net Mask</th><th class=hosts>MAC Address</th><th class=hosts>Speed bps</th></tr>";

			$Nics = mysql_query( "select * from network where Host=$HostID order by Interface" );
                        $i = 0;
                        while ( $i < mysql_num_rows( $Nics ) ) {

                                echo "<tr><td class=hosts>".mysql_result( $Nics, $i, 'Interface' )."</td><td class=hosts>".mysql_result( $Nics, $i, 'IPAddress')."</td><td class=hosts>".mysql_result( $Nics, $i, 'NetMask')."</td><td class=hosts>".mysql_result( $Nics, $i, 'MAC')."</td><td class=hosts align=right>".number_format( mysql_result( $Nics, $i, 'Speed'))."</td></tr>";
                                $i++;

                        }
			echo "</table>";

			echo "<table class=hosts>";
			echo "<tr><th class=hosts colspan=4><h3>Routing</h3></th></tr>";
			echo "<tr><th class=hosts>Destination</th><th class=hosts>Gateway</th><th class=hosts>Mask</th><th class=hosts>Interface</th></tr>";

			$Routes = mysql_query( "select * from routing where Host=$HostID order by Interface;" );
			$i = 0;
			while ( $i < mysql_num_rows( $Routes ) ) {

				echo "<tr><td class=hosts>".mysql_result( $Routes, $i, 'Destination')."</td><td class=hosts>".mysql_result( $Routes, $i, 'Gateway')."</td><td class=hosts>".mysql_result( $Routes, $i, 'GenMask' )."</td><td class=hosts>".mysql_result( $Routes, $i, 'Interface')."</td></tr>";
				$i++;
			}
			echo "</table><br>";

			########################################################################################
			# Disk information ...
			echo "<table class=hosts>";
			echo "<tr><th class=hosts colspan=4><center><h2>Disk configuration</h2></center></td></tr>";
#			echo "<tr><th class=hosts>Device</th><th class=hosts>Mount Point</th><th class=hosts>File System</th><th class=hosts>Size KB</th><th class=hosts>Date Found</th></tr>";
			echo "<tr><th class=hosts>Mount Point</th><th class=hosts>Size MB</th><th class=hosts>Date Found</th></tr>";

			$Disks = mysql_query( "select * from disks where Host=$HostID order by MountPoint" );
                        $i = 0;
                        while ( $i < mysql_num_rows( $Disks ) ) {

                                echo "<tr><td class=hosts>".mysql_result( $Disks, $i, 'MountPoint')."</td><td class=hosts align=right>".number_format(mysql_result( $Disks, $i, 'DiskSize'))."</td><td class=hosts>".mysql_result( $Disks, $i, 'DateFound')."</td></tr>";
                                $i++;

                        }
			echo "</table>";


		}
		echo "</table>";
		mysql_close();
	}

	function HostSave( $HostIP, $SysOwn, $Location, $OS, $SysEnv, $Status, $RemCons, $SNMP, $HostID, $DateCreated, $SNMPPort, $Decomm, $Register, $Ping ) {

		include("config.php");
		mysql_connect( $dbhost,$dbuser,$dbpasswd ) or die ("MySQL connect failed");
		mysql_select_db( $dbname );

		if ( ! isset ( $Decomm ) ) { $Decomm = '0'; }
		if ( ! isset ( $Register ) ) { $Decomm = '0'; }

		if ( $HostID == 0 ) {

			$OldHost = mysql_query( "select * from hosts where IPAddress='$HostIP';" );

			if ( mysql_num_rows( $OldHost ) > 0 ) {

			        echo "<form action='index.php?option=servers&sort=IPAddress' method=post><center><p>The host $HostIP is already defined in the database.</p><center>\n";
			        echo "<center><input type='submit' value='Continue'></center></form>";
				return;

			} else {

				$HostRec = mysql_query("insert into hosts (IPAddress, SysOwner, SysLocation, OS, SysEnvironment, Status, SysRemConsole, SysSNMP, DateCreated, SNMPPort, Decomm, Register, scan, ping ) values ( '$HostIP', '$SysOwn', '$Location', '$OS', '$SysEnv', '$Status', '$RemCons', '$SNMP', NOW(), $SNMPPort, $Decomm, $Register, '0', $Ping )");

			}

		} else {

			$Owner = mysql_query("select * from contacts where FullName = '$SysOwn'");
			$OwnerRec = mysql_fetch_row( $Owner );
			$HostRec = mysql_query("UPDATE hosts SET IPAddress='$HostIP',SysOwner=$SysOwn,SysLocation=$Location,OS=$OS,SysEnvironment='$SysEnv',Status='$Status',SysRemConsole='$RemCons',SysSNMP='$SNMP',SNMPPort='$SNMPPort',Decomm='$Decomm',Register='$Register',ping=$Ping WHERE id='$HostID'");

		}

		mysql_close();
		header( "Location: index.php?option=servers&sort=IPAddress" );

	}

	function HostDelete( $HostID ) {

		include("config.php");

                mysql_connect( $dbhost,$dbuser,$dbpasswd ) or die ("MySQL connect failed");
                mysql_select_db( $dbname );
                $HostList = mysql_query( "delete from hosts where id='$HostID'");
                mysql_close();
	}

#	function getcontact( $ContID ) {
#
#		include("config.php");
#
#                mysql_connect( $dbhost,$dbuser,$dbpasswd ) or die ("MySQL connect failed");
#                mysql_select_db( $dbname );
#                $Contact = mysql_query( "Select * from contacts where id='$ContID'");
#
#		if ( mysql_num_rows( $Contact ) != 0 ) {
#			return mysql_result( $Contact, '0', "FullName" );
#		} else {
#			return "No Owner Found.";
#		}
#	
#                mysql_close();
#
#	}
#
#	function getcontacts() {
#
#		include("config.php");
#
#                mysql_connect( $dbhost,$dbuser,$dbpasswd ) or die ("MySQL connect failed");
#                mysql_select_db( $dbname );
#                $Contact = mysql_query( "Select * from contacts");
#
#		if ( mysql_num_rows( $Contact ) != 0 ) {
#			return mysql_result( $Contact, 0, "FullName" );
#		} else {
#			return "No contacts Found.";
#		}
#	
#                mysql_close();
#
#	}


}

?>
