<?php
        /* If the user didn't login, go to the login page*/
        session_start();
        if ($_SESSION["login"] == false) {
            header("Location:index.php");
        } else {
        
        $host = "localhost";
        $user = "dbuser";
        $password = "goodbyeWorld";
        $database = "vote";
        $table = "items";
        $db = new mysqli($host, $user, $password, $database);
        if ($db->connect_error) {
                 die($db->connect_error);
        }
        /* update the number of the vote on the database*/
        if(isset($_POST['vote'])){
            if(isset($_POST['apple'])){
                $updateQuery = sprintf("update $table set number = number+1 where fruits = '%s'","apple");
                $tempResult = $db->query($updateQuery);
            }
            if(isset($_POST['orange'])){
                $updateQuery = sprintf("update $table set number = number+1 where fruits = '%s'","orange");
                $tempResult = $db->query($updateQuery);
            }
            if(isset($_POST['banana'])){
                $updateQuery = sprintf("update $table set number = number+1 where fruits = '%s'","banana");
                $tempResult = $db->query($updateQuery);
            }
            if(isset($_POST['pineapple'])){
                $updateQuery = sprintf("update $table set number = number+1 where fruits = '%s'","pineapple");
                $tempResult = $db->query($updateQuery);
            }
        }
        /* obtain the number of votes for each fruit from the database,
           and display the votes in descending order*/
        $apple;
        $orange;
        $banana;
        $pineapple;
        $votes = "";
        
        $sqlQuery1 = sprintf("select number from $table where fruits = '%s'", "apple");
        $result1 = $db->query($sqlQuery1);
        if ($result1) {
            while($row = $result1->fetch_assoc()) {
              $apple = implode($row);
          }
        } else {
          echo "SQL query failed";
        } 
        
        $sqlQuery2 = sprintf("select number from $table where fruits = '%s'", 'orange');
        $result2 = $db->query($sqlQuery2);
        if ($result2) {
          while ($recordArray = mysqli_fetch_array($result2, MYSQLI_ASSOC)) {
              $orange = implode($recordArray);
          }
          
        } else {
          echo "SQL query failed";
        }

        $sqlQuery3 = sprintf("select number from $table where fruits = '%s'", "banana");
        $result3 = $db->query($sqlQuery3);
        if ($result3) {
          while ($row = $result3->fetch_assoc()) {
              $banana = implode($row);
          }
        } else {
          echo "SQL query failed";
        }
        
        $sqlQuery4 = sprintf("select number from $table where fruits = '%s'","pineapple");
        $result4 = $db->query($sqlQuery4);
        if ($result4) {
          while ($row = $result4->fetch_assoc()) {
              $pineapple = implode($row);
          }
        } else {
          echo "SQL query failed";
        }
          
        $arr = array("Apple"=>$apple, "Orange"=>$orange, "Banana" =>$banana, "Pineapple"=>$pineapple);
        arsort($arr);
        $votes .= "<h1>Voting Result</h1>";
        $votes .= "<table>";
        $votes .= "<thread><tr><th>fruits</th><th>votes</th></tr></thread>";
        foreach ($arr as $key=>$value) {
            $votes .= "<tr><td>$key</td><td>$value</td></tr>";
        }
        $votes .= "</table>";
        echo $votes;
        
        $logout = "";
        $logout .= "<form action='vote.php' method='post' >";
        $logout .= "<input type='submit' name='logout' value='Logout'><br>";
        $logout .= "<h4>Double click Logout to log out current session</h4>";
        $logout .= "</form>";
        echo $logout;
        }
        if (isset($_POST["logout"])) {
            $_SESSION["login"] = false;
            session_destroy();
        }?>
<!doctype html>
<html>
    <head>
        <meta charset= 'utf-8' />
        <title>Vote for your favorite fruit</title>
        <script src="https://cdn.jsdelivr.net/npm/vue@2.5.13/dist/vue.min.js"></script>
        <link rel="stylesheet" href="vote.css">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    </head>
    
    <body>
        <form  method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" >
        <div id='selection'>
        <!-- Vote for the fruit -->
        <h1>Vote for your favourite fruit</h1>
        <input type="checkbox" name='apple' id="apple" value="Apple" v-model="checkedNames">
        <label for="appleLabel">Apple</label><br>
        <input type="checkbox" name='orange' id="orange" value="Orange" v-model="checkedNames">
        <label for="orangeLabel">Orange</label><br>
        <input type="checkbox" name='banana' id="banana" value="Banana" v-model="checkedNames">
        <label for="bananaLabel">Banana</label><br>
        <input type="checkbox" name='pineapple' id="pineapple" value="Pineapple" v-model="checkedNames">
        <label for="pineappleLabel">Pineapple</label>
        <br>
        <!-- Show the fruit which student votes on the screen-->
        <span>You voted: {{ checkedNames }}</span><br><br>
        <input type='submit' name='vote' id='vote'><br><br><br>
        </div><br>
        </form>
        
        <script>
            new Vue({
                el: '#selection',
                data: {
                  checkedNames: []
                }
            });
        </script>
        
        
    </body>
	
	

