<?php
        echo"<div class='container edit-hosts'>";
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
			echo "<p class='text-center bg-info'> I hope the server you are adding is currently up, and SNMP is enabled, or I will have to become aggressive when the server checks happen.<br/> Gentlemen, failure is not an option! <br/> A little magic you may wish to know. I do not like duplicates. You give me something I already know, I will quietly just throw it away. Because I am polite.</p>";
		} else {
			$query = "select IPAddress,HostName,contacts.FullName as Cont,SysLocation,OS,SysEnvironment,status.FullName,SysRemConsole,SysSNMP,hosts.DateCreated,contacts.MobilePhone,contacts.OfficePhone,contacts.ExtraPhone,contacts.Email,locations.LocName,environments.EnvName,oses.OSName,Platform,SysVersion,DateScanned,Memory,Router,Decomm,Register,SNMPPort,CPUCores,CPUModel,ping from hosts,contacts,locations,environments,status,oses where hosts.id = $HostID and SysOwner=contacts.id and SysLocation=locations.id and SysEnvironment=environments.id and status=status.id and OS=oses.id";
            $result=$GLOBALS['conn']->query($query);
			$HostRec = $result->fetch_assoc();

			$FuncContact = new hosts;
			$IPAddress = $HostRec['IPAddress'];
			$HostName = $HostRec['HostName'];
			$ContactName = $HostRec['Cont'];
			$LocID = $HostRec['SysLocation'];
			$OS = $HostRec['OS'];
			$Environment = $HostRec['SysEnvironment'];
			$Status = $HostRec['FullName'];
			$RemCons = $HostRec['SysRemConsole'];
			$SNMP = $HostRec['SysSNMP'];
			$DateCreated = $HostRec['DateCreated'];
			$ContactMobile = $HostRec['MobilePhone'];
			$ContactOffice = $HostRec['OfficePhone'];
			$ContactExtraPhone = $HostRec['ExtraPhone'];
			$ContactEmail = $HostRec['Email']; 
			$LocationName = $HostRec['LocName'];
			$EnvName = $HostRec['EnvName'];
			$OSType = $HostRec['OSName'];
			$Platform = $HostRec['Platform'];
			$Version = $HostRec['SysVersion'];
			$DateScan = $HostRec['DateScanned'];
			$Memory = $HostRec['Memory'];
			if ( $HostRec['Router']==2 ) { $Routing = 'Disabled'; } else { $Routing = 'Enabled'; }
			$Decomm=$HostRec['Decomm'];
			$Register=$HostRec['Register'];
			$SNMPPort=$HostRec['SNMPPort'];
			$CPUCores=$HostRec['CPUCores'];
			$CPUModel=$HostRec['CPUModel'];
			$Ping=$HostRec['ping'];
			
		}	

		if ( $_SESSION['userlevel'] > 2 ) {
			echo "<form action='index.php?option=SaveHost' method=post>";
			echo "<input type=hidden name='hostid' value=$HostID>";
			echo "<input type=hidden name='datecreated' value=$DateCreated>";
            echo "<table class='hosts'>";
            echo "<tr><th class=hosts colspan=4><center><h2 class='text-center'>Main Details</h2></center></td></tr>";
            echo" <tr>\n";
			if ( $HostID > 0 ) { 
				echo "\t\t\t\t\t\t\t<input class='text-center' type=hidden name='hostip' value=$IPAddress>\n";
				echo "\t\t\t\t\t\t\t<tr>\n\t\t\t\t\t\t\t\t<th class='hosts'>Host IP Address</th><td class='hosts'>$IPAddress</td></tr>\n";
				echo "<tr><th class='hosts'>Host Name</th><td class='hosts'>$HostName</td></tr>\n";
			} else {

				echo "<tr><th class='hosts'>Host IP Address</th><td class='hosts'><input type=text name='hostip' value=$IPAddress></td></tr>\n";
			}
			echo "<tr><th class='hosts'>Server owner</th><td class='hosts'><select name=sysown>\n";

			
			$query = "Select id,FullName from contacts order by FullName";
			$result = $GLOBALS['conn']->query($query);
			while ($Contact_row=$result->fetch_assoc()) {

				$Contact = $Contact_row['FullName'];
				echo "<option";
				if ( $Contact_row['FullName']== $ContactName ) {
					echo " selected";
				}
				echo " value='" . $Contact_row['id'] . "'>$Contact\n";
			}

			echo "</select></td></tr>\n";
			echo "<tr><th class='hosts'>Server Location</th>\n<td class='hosts'>\n<select name=sysloc>\n";

			$query = "select id,LocName from locations order by LocName";
			$Locations = $GLOBALS['conn']->query($query);
			//$i = 0;
			while ( $row=$Locations->fetch_assoc()) {

				$Location = $row["LocName"];
				echo "<option";
				if ( $row["id"] == $LocID ) {
					echo " selected";
				}
				echo " value='" . $row['id'] . "'>$Location\n";
			//	$i++;

			}

			echo "</select></td></tr>\n";

			echo "<tr><th class='hosts'>Server Operating System</th>\n<td class='hosts'>\n<select name=sysos>\n";

			$query = "select id,OSName from oses order by OSName";
			$SysOSes = $GLOBALS['conn']->query($query);
			//$i = 0;
			while ($row=$SysOSes->fetch_assoc() ) {

				$SysOS =$row["OSName"];
				echo "<option";
				if ( $row["id"] == $OS ) {
					echo " selected";
				}
				echo " value='" . $row['id']. "'>$SysOS\n";
				//$i++;

			}

			echo "</select></td></tr>\n";

			echo "<tr><th class='hosts'>Server Environment</th>\n<td class='hosts'>\n<select name=sysenv>\n";
			$query = "select id,EnvName from environments order by EnvName";
			$Environments = $GLOBALS['conn']->query($query);
			while ( $row = $Environments->fetch_assoc()) {

				$Env = $row["EnvName"];
				echo "<option";
				if ( $row["id"] == $Environment ) {
					echo " selected";
				}
				echo " value='" . $row['id'] . "'>$Env\n";
				

			}

			echo "</select></td></tr>\n";

			echo "<tr><th class='hosts'>Server Status</th>\n<td class='hosts'>\n<select name=sysstat>\n";
			$query = "select id,FullName from status order by FullName";
			$Statuses = $GLOBALS['conn']->query($query);
			while ($row=$Statuses->fetch_assoc()) {

				$Stat = $row["FullName"];
				echo "<option";
				if ( $row["FullName"] == $Status ) {
					echo " selected";
				}
				echo " value='" . $row['id'] . "'>$Stat\n";
			

			}

			echo "</select></td></tr>\n";


			echo "<tr><th class='hosts'>Remote Console</th><td class='hosts'><input type=text name='remcons' value=$RemCons></td></tr>\n";
			echo "<tr><th class='hosts'>Only show in register (No Scans will be done)</th><td class='hosts'><input type='checkbox' class='checkbox' name='register' value='1' ".(($Register)?' checked':'')."></td></tr>\n";
			echo "<tr><th class='hosts'>Decommission Host</th><td class='hosts'><input type='checkbox' name='decomm' value='1' ".(($Decomm)?' checked':'')."></td></tr>\n";
			echo "<tr><th class='hosts'>Can this host be pinged</th><td class='hosts'><input type='checkbox' name='ping' value='1' ".(($Ping)?' checked':'')."></td></tr>\n";
			echo "<tr><th class='hosts'>SNMP Community String</th><td class='hosts'><input type=text name='syssnmp' value=$SNMP></td></tr>\n";
			echo "<tr><th class='hosts'>SNMP Port</th><td class='hosts'><input type=text name='snmpport' value=$SNMPPort></td></tr>\n";
			echo "<tr><th class='hosts'>Date Created</th><td>$DateCreated</td></tr>";
			echo "<tr><td colspan=2><center><input type='submit'class='btn btn-primary' value='Save'></center></td></tr>";

		}

		if ( $HostID <> 0 ) {
            echo "<table class=hosts><tr>";
           
			echo "<tr><th class='hosts text-center' colspan=2><h1>$HostName ($IPAddress)</h1></th></tr>";
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
			echo "<tr><th class=hosts colspan=2><h2 class='text-center'>Hardware configuration</h2></td></tr>";
			echo "<tr><th class=hosts>Item</th><th class=hosts>Information</th></tr>";
			echo "<tr><th class=hosts>Physical Memory (MB)</th><td class=hosts>".number_format($Memory)."</td></tr>";
			echo "<tr><th class=hosts>CPU Model</th><td class=hosts>$CPUModel</td></tr>";
			echo "<tr><th class=hosts>CPU Cores</th><td class=hosts>$CPUCores</td></tr>";
			echo "</table><br>";
			
			

			########################################################################################
			# Network Information ..
			echo "<table class=hosts>";
			echo "<tr><th class=hosts colspan=2><h2 class='text-center'>Network configuration</h2></td></tr>";
			echo "<tr><th class=hosts>Routing enabled?</td><td class=hosts>".$Routing."</td></tr>";
			echo "</table>";
			echo "<table class=hosts>";
			echo "<tr><th class=hosts colspan=5><h3>Interfaces</h3></th></tr>";
			echo "<tr><th class=hosts>Interface</th><th class=hosts>IP Address</th><th class=hosts>Net Mask</th><th class=hosts>MAC Address</th><th class=hosts>Speed bps</th></tr>";

			$query = "select * from network where Host=$HostID order by Interface";
			$Nics = $GLOBALS['conn']->query($query);
                        
                        while ( $row = $Nics->fetch_assoc()) {

                                echo "<tr><td class=hosts>".$row['Interface']."</td><td class=hosts>".$row['IPAddress']."</td><td class=hosts>".$row['NetMask']."</td><td class=hosts>".$row['MAC']."</td><td class=hosts align=right>".number_format( $row['Speed'])."</td></tr>";
                                //$i++;

                        }
			echo "</table>";

			echo "<table class=hosts>";
			echo "<tr><th class=hosts colspan=4><h3 class='text-center'>Routing</h3></th></tr>";
			echo "<tr><th class=hosts>Destination</th><th class=hosts>Gateway</th><th class=hosts>Mask</th><th class=hosts>Interface</th></tr>";

			$query= "select * from routing where Host=$HostID order by Interface;" ;
			$Routes = $GLOBALS['conn']->query($query);
			while ( $row = $Routes->fetch_assoc() ) {

				echo "<tr><td class=hosts>".$row['Destination']."</td><td class=hosts>".$row['Gateway']."</td><td class=hosts>".$row['GenMask']."</td><td class=hosts>".$row['Interface']."</td></tr>";
				//$i++;
			}
			echo "</table><br>";

			########################################################################################
			# Disk information ...
			echo "<table class=hosts>";
			echo "<tr><th class=hosts colspan=4><center><h2 class='text-center'>Disk configuration</h2></center></td></tr>";
#			echo "<tr><th class=hosts>Device</th><th class=hosts>Mount Point</th><th class=hosts>File System</th><th class=hosts>Size KB</th><th class=hosts>Date Found</th></tr>";
			echo "<tr><th class=hosts>Mount Point</th><th class=hosts>Size MB</th><th class=hosts>Date Found</th></tr>";

			$query ="select * from disks where Host=$HostID order by MountPoint" ;
			$Disks = $GLOBALS['conn']->query($query);
              
                        while ( $row=$Disks->fetch_assoc() ) {

                                echo "<tr><td class=hosts>".$row['MountPoint']."</td><td class=hosts align=right>".number_format($row['DiskSize'])."</td><td class=hosts>".$row['DateFound']."</td></tr>";
                                //$i++;

                        }
			echo "</table>";


		}
        echo "</table></div>";
       
?>