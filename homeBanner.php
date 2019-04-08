    <?php
       echo"<html>
       <head>
           <title>SARS SERVER REGISTER</title>
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
   
   
   
       
            <section id='head'>
               <div class='img'>
                   <div class='container text-center'>
                   <div class='welcome-title'>
                       <h1>Sars Server Register</h1>
                       <p>Made with love for the Unix Team.</p>
                   </div>
                   </div>
                   
               </div>
          </section>
          ";
    ?>