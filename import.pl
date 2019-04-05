#!/usr/bin/perl

use DBI;

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

open ( infile, "< servers.txt" );

foreach $line (<infile> ) {
	print $line."\n";
	chomp $line;
	$query = "select * from hosts where HostName='$line';";
	my $HostCheck = $dbh->prepare($query);
	$HostCheck->execute();
	if ( $HostCheck->rows == 0 ) {

		$query = "INSERT INTO hosts (IPAddress,OS,DateCreated) VALUES ('$line', 'Linux', NOW());"; 
		my $SetDate = $dbh->prepare($query);
		$SetDate->execute();

	}

}

$dbh->disconnect();
