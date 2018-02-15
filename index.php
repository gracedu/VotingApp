<?php
          session_start();
          $_SESSION["login"] = 0;
        
          /* access the database to see whether the student is a user or not*/
          $host = "localhost";
          $user = "dbuser";
          $password = "goodbyeWorld";
          $database = "vote";
          $table = "users";
          $db = new mysqli($host, $user, $password, $database);
          if ($db->connect_error) {
              die($db->connect_error);
           }
          
            if(isset($_POST['go'])){
                $userID = $_POST['user'];
                $sqlQuery = sprintf("select * from $table where name = '%s'", $userID);
                $result = $db->query($sqlQuery);
                if($result->num_rows === 0){
                    echo "user not found";
                }else{
                    $_SESSION["login"] = 1;
                    header("Location:vote.php");
                }
            }
?>
<!doctype html>
<html>
    <head>
        <meta charset= 'utf-8' />
        <title>user authentication</title>
        <link rel="stylesheet" href="authentication.css"> 
    </head>
    
    <body>
        <div class='center'>
        <form  method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" >
        <fieldset>
            <!-- Students need to enter their name to login -->
          <h2>Enter user name</h2>
          <input type='text' name='user'><br><br>
          <input type='submit' name='go' ><br>
        </fieldset>
        </form>
        </div>
     </body>