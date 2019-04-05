#!/usr/bin/perl

###############################################################################
# Script      : gather.pl
# Author      : Dave le Roux
# Date        : 2011/05/26
#
# Purpose     : Use the mySQL list of server IP's then use SNMP to populate the 
#               host information.

use Net::SNMP qw(:snmp);
use Net::Ping;
use DBI;
#use Date::Manip;

###############################################################################
# Set the following variables for the MySQL database.

my $sqlhost = "localhost";
my $sqldatabase = "dredger";
my $sqluser = "dredger";
my $sqlpassword = "dr3dg3r";

###############################################################################
# Establish a MySQL connection.

my $DBConnecter = "DBI:mysql:".$sqldatabase.":host=".$sqlhost;
my $dbh = DBI->connect($DBConnecter, $sqluser, $sqlpassword ) || die "DB connection failed : $DBI::errstr";

###############################################################################
# Extract the host info from the database.

my $query = "select id,IPAddress,SysSNMP,SNMPPort,Decomm,Register,ping from hosts order by IPAddress;";
my $queryhandle = $dbh->prepare($query);
$queryhandle->execute();
$queryhandle->bind_columns( undef, \$id, \$address, \$snmpcom, \$snmpport, \$decomm, \$Register, \$Ping );

###############################################################################
# Peddle through the hosts and fetch all the goodies.

while ( $queryhandle->fetch() ) {

	#################################
	# Define the Host state variable.
	# 0 = Host is Fine.
	# 1 = Host is down.
	# 2 = SNMP is broken.

	my $HostState='0';

	print $address."\n";

	######################################################################
	# Do not try SNMP to hosts that are only registered or decommissioned.

	if (( $Register == 1 )||($decomm == 1 )) {

		next;

	} else {

		############################
		# Check that the host is up.

		my $Ping = Net::Ping->new( "icmp" );
		if (( $Ping->ping( $address, 2 ) )||( $Ping != '1' )) {
	
			##########################
			# Set up the SNMP session.

		        my ( $SNMP, $Error ) = Net::SNMP->session(
		                        -hostname       => $address,
					-port		=> $snmpport,
		                        -community      => $snmpcom,
		                        -timeout        => 20,
		        );
		
			#########################################
			# Fetch all the little bits of host info.

			if ( ! get_hostinfo( $id, $SNMP ) ) {
		
				log_message( $id, $address." SNMP query failed." );
				$HostState = '2';
		
			} else {
			
				############################################
				# Fetch all the other chunks of information.

				get_network( $id, $SNMP );
				get_disks( $id, $SNMP );
				get_cpu ( $id, $SNMP );

				log_message( $id, $address." SNMP query succeeded." );
				$query = "UPDATE hosts SET DateScanned=NOW() where id=$id;";
				my $SetDate = $dbh->prepare($query);
				$SetDate->execute();
				$HostState = '0';
		
			}
	
			$SNMP->close();
	
		} else {
	
			#############################
			# Log that the host was down.

			print "\tHost is down.\n";
			$HostState = '1';
			log_message( $id, $address." Host is down." );
	
		}

	}

	#####################################################
	# Set the state of the host variable in the database.

	$query = "UPDATE hosts SET scan=$HostState where id='$id';";
	my $SetHostStat = $dbh->prepare($query);
	$SetHostStat->execute();

}

$dbh->disconnect();

###############################################################################
# This is where the main program ends, and the sub routines all start.
###############################################################################

###################################################################################
# A small procedure to throw errors and other information into the logger database.

sub log_message {

	my ( $ID, $Message ) = @_;
	$query = "INSERT INTO logs (id,Date,Notes) VALUES ( '$ID', NOW(), '$Message' );";
	my $WriteLog = $dbh->prepare($query);
	$WriteLog->execute();

}

###############################################################################
# Fetch the host name and other info of the IP address and plonk it in the 
# database.

sub get_hostinfo {

	my ( $ID, $SNMPCon ) = @_;
	my $OS = "";

        my $snmp_HostName = $SNMPCon->get_request( -varbindlist => [ "1.3.6.1.2.1.1.5.0" ], );

        if ( ! defined $snmp_HostName ) {

		return 0;

        } else {

		my $HostName = $snmp_HostName->{"1.3.6.1.2.1.1.5.0"};
		my $snmp_Routing = $SNMPCon->get_request( -varbindlist => [ ".1.3.6.1.2.1.4.1.0" ], );
        	my $snmp_OSver = $SNMPCon->get_request( -varbindlist => [ ".1.3.6.1.2.1.1.1.0" ], );
		my $Routing = $snmp_Routing->{".1.3.6.1.2.1.4.1.0"};
		my $SysVersion = $snmp_OSver->{".1.3.6.1.2.1.1.1.0"};

		my $SysPlatform = $SysVersion;

		if ( $SysVersion =~ m/^Linux/ ) {
			$OS = "Linux";
			my @Linux = split(' ',$SysVersion);
			$SysPlatform =~ s/^.*\s//g;
			$SysVersion = $Linux[2];
		} else {
			$SysVersion =~ s/\n/ /g;
			$OS = "AIX";
			$SysVersion =~ s/^.*System Runtime //;
			$SysVersion =~ s/ TCP\/IP.*$//;
		}

		print "\t$HostName\n";
		$query = "UPDATE hosts SET HostName='$HostName',scan=NULL,DateScanned=NOW(),Router='$Routing',SysVersion='$SysVersion',Platform='$SysPlatform' where id='$ID';";
		my $SetHostName = $dbh->prepare($query);
		$SetHostName->execute();

		log_message( $ID, $HostName." host name discovered and set." );

		return 1;

	}

}

###############################################################################
# Fetch the network interfaces of the host and populate the network table.

sub get_network {

	my ( $Host, $SNMPCon ) = @_;

	##########################
	# Physical Nic attributes.

	my $oid_IFName = ".1.3.6.1.2.1.2.2.1.2";
	my $oid_IFSpeed = ".1.3.6.1.2.1.2.2.1.5";
	my $oid_IFMAC = ".1.3.6.1.2.1.2.2.1.6";

	############################
	# TCP/IP Binding attributes.

	my $oid_IP = ".1.3.6.1.2.1.4.20.1.1";
	my $oid_Nic = ".1.3.6.1.2.1.4.20.1.2";
	my $oid_NMask = ".1.3.6.1.2.1.4.20.1.3";

	###############
	# Routing OIDs.

	my $oid_RouteDest = ".1.3.6.1.2.1.4.21.1.1";
	my $oid_RouteIF = ".1.3.6.1.2.1.4.21.1.2";
	my $oid_RouteNextHop = ".1.3.6.1.2.1.4.21.1.7";
	my $oid_RouteMask = ".1.3.6.1.2.1.4.21.1.11";

	###################
	# Output variables.

	my $snmp_IP;
	my $snmp_Nic;
	my $snmp_IF;
	my $snmp_MAC;
	my $snmp_NetMask;
	my $snmp_Speed;

	####################
	# Holding variables.

	my $hold_Nic;
	my $hold_Names;

	#############################################################
	# Fetch all the entries from the host using the SNMP session.

	my $Interfaces = $SNMPCon->get_entries( -columns => [ $oid_IFName, $oid_IFSpeed, $oid_IFMAC ], );
	my $IPAdds = $SNMPCon->get_entries( -columns => [ $oid_IP, $oid_Nic, $oid_NMask ], );
	my $Routes = $SNMPCon->get_entries( -columns => [ $oid_RouteDest, $oid_RouteIF, $oid_RouteNextHop, $oid_RouteMask ], );

	#############################################
	# Process the network interfaces, one by one.

	while (( $OID, $snmp_Value ) = each( %$IPAdds )) {

		if ( oid_base_match( $oid_IP, $OID )) {

			$snmp_IF = $OID;
			$snmp_Nic = '.1.3.6.1.2.1.2.2.1.2.';
			$snmp_MAC = '.1.3.6.1.2.1.2.2.1.6.';
			$snmp_NetMask = $OID;
			$snmp_Speed = '.1.3.6.1.2.1.2.2.1.5.';

			substr($snmp_NetMask, 20, 1) = '3';
			substr($snmp_IF, 20, 1) = '2';
			
			$snmp_IP = $snmp_Value;
			$hold_Nic = $IPAdds->{$snmp_IF};
			$snmp_Nic = $snmp_Nic.$hold_Nic;
			$snmp_MAC = $snmp_MAC.$hold_Nic;
			$snmp_Speed = $snmp_Speed.$hold_Nic;

			$hold_Names = $Interfaces->{$snmp_Nic};
			$hold_Names =~ s/;.*$//;

#			print "\tInterface : ".$hold_Nic." Name : ".$hold_Names."\n";

			my $MACAddr = join(':',($Interfaces->{$snmp_MAC} =~ m/(?:0x)?(\w{2})/g));

			my $query = "select * from network where Host='$Host' and Interface='$hold_Names';";
			my $Findit = $dbh->prepare($query);
			$Findit->execute();

			if ( $Findit->rows == 0 ) {
				$query = "insert into network (Host,IPAddress,Interface,MAC,NetMask,Speed) VALUES ( '$Host', '$snmp_IP', '$hold_Names', '$MACAddr', '$IPAdds->{$snmp_NetMask}', '$Interfaces->{$snmp_Speed}' );";
				my $Set = $dbh->prepare($query);
				$Set->execute();
			} else {

				$query = "UPDATE network SET IPAddress='$snmp_IP', MAC='$MACAddr',NetMask='$IPAdds->{$snmp_NetMask}', Speed='$Interfaces->{$snmp_Speed}' where Host=$Host and Interface='$hold_Names';";
				my $Set = $dbh->prepare($query);
				$Set->execute();

			}


		}

	}
	
	while (( $OID, $snmp_Value ) = each( %$Routes )) {

		if ( oid_base_match( $oid_RouteDest, $OID, )) {

			my ( $oid_RouteNH, $oid_RouteMask, $oid_RouteIF )  = ($OID) x 3;

			substr( $oid_RouteNH, 20, 1 ) = '7';
			substr( $oid_RouteMask, 20, 1 ) = '11';
			substr( $oid_RouteIF, 20, 1 ) = '2';

			my $RouteDest = $Routes->{$OID};
			my $RouteNextHop = $Routes->{$oid_RouteNH};
			my $RouteMask = $Routes->{$oid_RouteMask};
			my $RouteIF = $Routes->{$oid_RouteIF};

                        $RouteIF = $Interfaces->{".1.3.6.1.2.1.2.2.1.2.".$RouteIF};
                        $RouteIF =~ s/;.*$//;


#			print "\t\tDest : ".$RouteDest." Hop : ".$RouteNextHop." Mask : ".$RouteMask." Interface : ".$RouteIF."\n";

			my $query = "select * from routing where Host='$Host' and Destination='$RouteDest';";
                        my $Findit = $dbh->prepare($query);
                        $Findit->execute();

                        if ( $Findit->rows == 0 ) {

                                $query = "insert into routing (Host,Destination,Gateway,GenMask,Interface) VALUES ( '$Host', '$RouteDest', '$RouteNextHop', '$RouteMask', '$RouteIF' );";

                        } else {

                                $query = "UPDATE routing SET Gateway='$RouteNextHop', GenMask='$RouteMask', Interface='$RouteIF' where Host=$Host and Destination='$RouteDest';";

                        }

			my $Set = $dbh->prepare($query);
			$Set->execute();

		}

	}

}

###############################################################################
# Fetch the disks of the host and populate the disks table.

sub get_disks {

	my ( $Host, $SNMPCon ) = @_;

	# SNMP Data
	my $oid_Table = '1.3.6.1.2.1.25.2.3.1';
	my $oid_Index = '1.3.6.1.2.1.25.2.3.1.1';
	my $oid_Type  = '1.3.6.1.2.1.25.2.3.1.2';
	my $oid_Descr = '1.3.6.1.2.1.25.2.3.1.3';
	my $oid_Alloc = '1.3.6.1.2.1.25.2.3.1.4';
	my $oid_Size  = '1.3.6.1.2.1.25.2.3.1.5';
	my $oid_Used  = '1.3.6.1.2.1.25.2.3.1.6';
	my $oid_Dev   = '1.3.6.1.2.1.25.3.8.1.3';

	# Output variables.
	my $snmp_Device;
	my $snmp_MountPoint;
	my $snmp_FileSystem;
	my $snmp_DiskSize;
	my $snmp_FSTabOptions;

	# Holding variables.
	my $hold_Index = $SNMPCon->get_entries( -columns =>  [ $oid_Index, $oid_Type, $oid_Descr, $oid_Alloc, $oid_Size, $oid_Used ], );

	while (( $OID, $Disk ) = each( %$hold_Index )) {

		if ( oid_base_match( $oid_Index, $OID )) {

#			$snmp_Device = $hold_Index->{$oid_Type.".".$Disk};
			$snmp_MountPoint = $hold_Index->{$oid_Descr.".".$Disk};
			$snmp_FileSystem = $hold_Index->{$oid_Type.".".$Disk};
			$hold_Alloc = $hold_Index->{$oid_Alloc.".".$Disk};
			$snmp_DiskSize = ((( $hold_Index->{$oid_Size.".".$Disk} * $hold_Alloc)/1024)/1024);

			if ( $snmp_FileSystem eq '1.3.6.1.2.1.25.2.1.2' ) {

				$query = "UPDATE hosts SET Memory='$snmp_DiskSize' where id='$Host'";
				my $Mem = $dbh->prepare($query);
				$Mem->execute();
			} elsif ( $snmp_MountPoint =~ m/(\/proc|\/sys|memory|yast)/i ) {

				next;
		
			} elsif ( ( $snmp_FileSystem eq '1.3.6.1.2.1.25.2.1.4' )||( $snmp_FileSystem eq '1.3.6.1.2.1.25.2.1.3' ) ) {

				my $query = "select * from disks where Host='$Host' and MountPoint='$snmp_MountPoint';";
				my $Findit = $dbh->prepare($query);
				$Findit->execute();
	
				if ( $Findit->rows == 0 ) {
					$query = "INSERT into disks (Host,MountPoint,FileSystem,DiskSize,DateFound) VALUES ( '$Host', '$snmp_MountPoint', '$snmp_FileSystem', '$snmp_DiskSize', NOW() );";
					my $Set = $dbh->prepare($query);
					$Set->execute();
				} else {
	
					$query = "UPDATE disks SET DiskSize='$snmp_DiskSize', FileSystem='$snmp_FileSystem' where Host='$Host' and MountPoint='$snmp_MountPoint' ;";
					my $Set = $dbh->prepare($query);
					$Set->execute();
	
				}


			}

		}

	}

}

###################################
# Fetch the cpu info from the host.

sub get_cpu {

	my ( $Host, $SNMPCon ) = @_;

	# SNMP Data
	my $oid_Type = '.1.3.6.1.2.1.25.3.2.1.2';
	my $oid_Desc = '.1.3.6.1.2.1.25.3.2.1.3';

	# Output variables.
	my $snmp_Device;
	my $snmp_Desc;

	# Holding variables.
	my $hold_Index = $SNMPCon->get_entries( -columns =>  [ $oid_Type, $oid_Desc ], );
	my $CPUCount = 0;
	my $CPUDesc = "";


	while (( $OID, $Device ) = each( %$hold_Index )) {

		if ( oid_base_match( $oid_Type, $OID )&&( $Device eq '.1.3.6.1.2.1.25.3.1.3' ) ) {

			$snmp_Device = $OID;
			substr( $snmp_Device, 22, 1 ) = '3';
			$snmp_Desc = $hold_Index->{$snmp_Device};

			$CPUCount++;
			$CPUDesc = $snmp_Desc;

		}
	
	}

	$query = "UPDATE hosts SET CPUCores='$CPUCount', CPUModel='$snmp_Desc' where id='$Host';";
	my $Set = $dbh->prepare($query);
	$Set->execute();

}
