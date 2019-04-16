<?php
		echo"
		<html>
		<head>
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
			<div class='navigation'>
			   <nav class='navbar navbar-expand-lg navbar-light'>
				 <a class='navbar-brand' href='index.php?option=home'>
				   <img src='images/SARS-WebBanner-2.png'>
				 </a>
				<button class='navbar-toggler' type='button' data-toggle='collapse' data-target='#navbarNavAltMarkup' aria-controls='navbarNavAltMarkup' aria-expanded='false' aria-label='Toggle navigation'>
				<span class='navbar-toggler-icon'></span>
				</button>
				  <div class='collapse navbar-collapse' id='navbarNavAltMarkup'>
					   <div class='navbar-nav ml-auto'>
							<li class='nav-item dropdown'>
							<a class='nav-link dropdown-toggle' href='#' id='navbarDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>Useful links</a>
								<div class='dropdown-menu' aria-labelledby='navbarDropdown'>
								<a class='dropdown-item' href='#'>Google</a>
								 <div class='dropdown-divider'></div>
								<a class='dropdown-item' href='#'>Brooklyn Nagios</a>
								 <div class='dropdown-divider'></div>
								 <a class='dropdown-item' href='#'>Linux Wiki</a>
								  <div class='dropdown-divider'></div>
								  <a class='dropdown-item' href='#'>Brooklyn Cacti</a>
								   <div class='dropdown-divider'></div>
								   <a class='dropdown-item' href='#'>ITM Portal</a>
									<div class='dropdown-divider'></div>
									<a class='dropdown-item' href='#'>Exchange Web Portal</a>
									 <div class='dropdown-divider'></div>
									 <a class='dropdown-item' href='#'>SARS Remedy</a>
									  <div class='dropdown-divider'></div>
									  <a class='dropdown-item' href='#'>SARS Portal</a>
								<div class='dropdown-divider'></div>
								<a class='dropdown-item' href='#'>Something else here</a>
								</div>
						   </li>
						   <a href='index.php?option=sms' class='nav-item nav-link'>SMS Despatcher</a>
						   <a href='index.php?option=servers&sort=IPAddress' class='nav-item nav-link'>Server Register</a>  
						   ";
	
            if($_SESSION['userlevel'] > 3){
				echo"							
				<a href='index.php?option=contacts' class='nav-item nav-link'>Server Contacts</a>
				<a href='index.php?option=users' class='nav-item nav-link'>Register Users</a>
				<a href='index.php?option=logout' class='nav-item nav-link'>Logout</a>
				";

			}
			else{
				echo"							
				<a href='index.php?option=login' class='nav-item nav-link'>Login</a>";

			}
  echo"
  </div>
  </div>
</nav>
</div>	";
	

?>