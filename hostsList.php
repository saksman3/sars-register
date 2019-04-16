

<?php
    echo"
    <div class='container hosts-list'>
    <div class='info-table text-center'>
    <h1 class=''>SARS Server Register</h1>";
    if($_SESSION['userlevel'] > 2){
       echo" <p class=''><a href='index.php?option=edithost&hostid=0'>Add a new server</a></p>";
    }
  echo"  <p class='bg-info'>Please click on the Host name or IP Address to see more detail about the host.<br/> Click on the column heading to sort the hosts</p>
    </div>
<table class='table table-bordered table-hover text-condensed table-striped'>
 <thead>
     <th><a href='index.php?option=servers&sort=HostName'>Host Name</a></th>
     <th><a href='index.php?option=servers&sort=IPAddress'>Host IP</a></th>
     <th><a href='index.php?option=servers&sort=contacts.FullName,HostName'>System Owner</a></th>
     <th><a href='index.php?option=servers&sort=locations.LocName,HostName'>Location</a></th>
     <th><a href='index.php?option=servers&sort=environments.EnvName,HostName'>Environment</a></th>
     <th><a href='index.php?option=servers&sort=status.FullName,HostName'>Status</a></th>
     <th><a href='index.php?option=servers&sort=oses.OSName,HostName'>OS Type</a></th>
     <th>Remote Console</th>
     <th>Server State</th>
     <th>Action</th>
 </thead>
 <tbody>";
      //get hosts lists 
         $HostStates = array( "Host is Fine", "Host is down", "SNMP Broken", "Registered only" );
		 $query ="select hosts.id,HostName,IPAddress,contacts.FullName as cont,locations.LocName,environments.EnvName,status.FullName,scan,oses.OSName,SysRemConsole,Decomm,Register from hosts,contacts,locations,environments,status,oses where hosts.SysOwner=contacts.id and hosts.SysLocation=locations.id and hosts.SysEnvironment=environments.id and hosts.Status=status.id and hosts.OS=oses.id order by $SortOrder ASC"; 
         // execute the query and store result
         $result=$GLOBALS['conn']->query($query);
         //get results length
         $NumRows = mysqli_num_rows($result);
         if ( $NumRows == 0) {
             echo"No hosts have been defined in your database.";
         }else{
            $i = 0;
			$FlipFlop = true;
            $HostContact = new hosts;
            while ( $row = $result->fetch_assoc() ) {
                
				$HostID = $row["id"];
                $ContactID =$row['cont'];
                echo"
                <tr>";
                echo"<td><a href='index.php?option=edithost&hostid=$HostID'>".$row["HostName"]."</a></td>";
                echo"<td><a href='index.php?option=edithost&hostid=$HostID'>" .$row["IPAddress"] . "</a></td>";
                echo"<td>".$row["cont"]."</td>";
                echo"<td>" .$row["LocName"]. "</td>";
                echo"<td>" .$row["EnvName"]. "</td>";
                echo"<td>" .$row["FullName"]. "</td>";
                echo"<td>" . $row["OSName"]. "</td>";
                if ( stristr ( $row["SysRemConsole"], "http" ) ) {
					echo "<td><a href='" .$row["SysRemConsole"] . "' target=_blank>" . $row["SysRemConsole"] . "</a></td>";
				} else {
					echo "<td>" . $row["SysRemConsole"]. "</td>";
                }
                if ( $row["Register"] ) { 
					echo "<td style='background-color: orange;'>Registered only</td>";
				} else if ($row["Decomm"] ) { 
					echo "<td style='background-color: orange;'>Decommissioned</td>"; 
				} else {
					echo "<td " . (($row['scan'] == '0') ? "" : "style='background-color: orange;'") . ">" . $HostStates[ $row["scan"] ] ."</td>";
				}

				if ( $_SESSION['userlevel'] > 2 ) {
					echo "<td><a href=index.php?option=delhost&hostid=$HostID>Del</a></td>";
				} else {
					echo "<td>None</td>";
				}
				echo "</tr>";
				
			}
			$result->free();

            
         }
echo"</tbody>
    </table>
  </div>
    ";
?>
<!-- <head>
			<title>$TitleString</title>
			<link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css'>
			<link href='styles/styles.css' rel='stylesheet' type='text/css'>
					<script language='javascript' type='text/javascript'>
						function limitText(limitField, limitCount, limitNum) {
						if (limitField.value.length > limitNum) {
						limitField.value = limitField.value.substring(0, limitNum);
						} else {
						limitCount.value = limitNum - limitField.value.length;
						}
						}
					</script>
						<script src='https://code.jquery.com/jquery-3.3.1.slim.min.js'></script>
						<script src='https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js'></script>
						<script src='https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js'></script>
		</head>
<body>
  <div class='container-fluid'>
      <div class='info-table text-center'>
      <h1 class=''>SARS Server Register</h1>
      <p class=''><a href='index.php?option=edithost&hostid=0'>Add a new server</a></p>
      <p class='bg-info'>Please click on the Host name or IP Address to see more detail about the host.<br/> Click on the column heading to sort the hosts</p>
      </div>
  <table class='table table-bordered table-hover text-condensed table-striped'>
   <thead>
       <th><a href='index.php?option=servers&sort=HostName'>Host Name</a></th>
       <th><a href='index.php?option=servers&sort=IPAddress'>Host IP</a></th>
       <th><a href='index.php?option=servers&sort=contacts.FullName,HostName'>System Owner</a></th>
       <th><a href='index.php?option=servers&sort=locations.LocName,HostName'>Location</a></th>
       <th><a href='index.php?option=servers&sort=environments.EnvName,HostName'>Environment</a></th>
       <th><a href='index.php?option=servers&sort=status.FullName,HostName'>Status</a></th>
       <th><a href='index.php?option=servers&sort=oses.OSName,HostName'>OS Type</a></th>
       <th>Remote Console</th>
       <th>Server State</th>
       <th>Action</th>
   </thead>
   <tbody>
      
   </tbody>
</table>
  </div>
</body> -->