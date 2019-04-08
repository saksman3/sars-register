<?php

  if ( $_SESSION['failed'] ) {
     echo"<p>Your login attempt failed, please try again.</p>";
  }
   echo"
   <form id='form1' name='form1' method='post' action='$_SERVER[PHP_SELF]' class='text-center'>
   <div class='form-wrapper'>
   <h1 >Login page</h1>
   
   <div class='form-group'>
   <input name='username' type='text' id='username' class='form-control' placeholder='Username'/>
   </div>
   
  <div class='form-group'>
  <input name='password' type='password' id='password' class='form-control' placeholder='Password' />
  </div>
   <input name='Login' type='submit' id='Login' value='Login' class='btn btn-primary' />
   </div>
   </form>
   ";

?>