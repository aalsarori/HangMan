
<html>

    <body>
        <h1>  login </h1>  
        <form action="logIn.php" method = "post">
            User name: <input type = "text" name = "userName"> <br>
            password: <input type = "password" name = "password"> </br>
            <input type = "submit" name = "submit" value = "login"> </button> </br>
        </form>

        <form action="signUp.php">

            <input type = "submit" name = "submit" value = "Sign up">

        </form>

    </body>

</html>

<?php 

if(isset($_POST['submit'])){

    $servername = "sql102.epizy.com";
    $usernames = "epiz_31690301";
    $passwords = "ETeo3AR4aBEqrD";
    $dbname = "epiz_31690301_aalsarori";

    //Create connection
    $conn = new mysqli($servername, $usernames, $passwords, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $usr = $_POST['userName'];
    $pw = $_POST['password'];
    

    $sql = "SELECT username FROM usernames WHERE username = '$usr'";

    $returnQ = $conn->query($sql);

    // if the sql query returns nothing, the user does not exist
    if($returnQ->num_rows === 0){
        
        echo "username not found. Sign up SIR! <br>";
    }

    else{

        $salt = "SELECT salt FROM usernames WHERE username = '$usr'";
        $theSalt = $conn->query($salt);


        //echo "the salt is: " . strval($theSalt) . " ";
        $saltValue = "";

        if($theSalt->num_rows > 0){
            while($row = $theSalt->fetch_assoc()){
                $saltValue = $row["salt"];
            }
        }

        $hashedPassword= hash('sha256', $saltValue . $pw );

        

        $sqlpw = "SELECT username, hash FROM usernames WHERE username = '$usr' AND hash = '$hashedPassword'";
        $runPw = $conn->query($sqlpw);

        if($runPw->num_rows === 0) {
            echo "wrong password entered <br>";
        }
        else{
            header("Location: ./game.php");
        }

    }

    
    
}

?>