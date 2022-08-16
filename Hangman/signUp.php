
<html>

<body>
    <h1>  Sign up </h1>  
    <form action="signUp.php" method = "post">
        User name: <input type = "text" name = "name"> <br>
        password: <input type = "password" name = "password"> <br>
        confirm password:  <input type = "password" name = "cPassword"> <br>
        <input type = "submit" name = "submit" value = "Sign up"> </button> </br>
    </form>

    <form action="logIn.php">
        
        <input type = "submit" name = "submit" value = "Log in">

    </form>
    
</body>
 
</html>

<?php


if(isset($_POST['submit'])){

    $servername = "sql102.epizy.com";
    $usernames = "epiz_31690301";
    $passwords = "ETeo3AR4aBEqrD";
    $dbname = "epiz_31690301_aalsarori";

    $user = $_POST['name'];
    $password = $_POST["password"]; 
    $randomText= md5(uniqid(rand(), TRUE));
    $salt=  substr($randomText, 0, 3);
    $hashedPassword= hash('sha256', $salt . $password );

    //Create connection
    $conn = new mysqli($servername, $usernames, $passwords, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }     

    $usrsql = "SELECT username FROM usernames WHERE username = '$user'";

    $usrQuery = $conn->query($usrsql);

    // if the sql query returns nothing, the user does not exist
    if($usrQuery->num_rows > 0){
        
        echo "username already exists! Pick a new username <br>";
    }

    else {



        if($_POST['password'] === $_POST['cPassword']){

        

            $sql = "INSERT INTO usernames (username, hash, salt) VALUES ('$user', '$hashedPassword', '$salt')";

            if ($conn->query($sql) === TRUE) {
                echo "Account created successfully!";
                header("Location: ./game.php");
            } 
            else {
            echo "Error: " . $sql . "<br>" . $conn->error;
            }

        }

        

        else {
            echo "ERROR: Passwords don't match!";
        }
    }

}

?>