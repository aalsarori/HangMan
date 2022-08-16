

<html>

<h1>Welcome to the hangman game</h1>

    <form action="game.php" method = "post">

    Enter a letter: <input type = "text" name = "letter"> 
    <input type = "submit" name = "submitLetter" value = "Enter"> <br>
   
    </form>

    <form action="game.php" method = "post">
        <input type="submit" name = "restart" value ="restart">
    </form>

    <form action="logIn.php" method = "post">
        <input type="submit" name = "logout" value ="logout">
    </form>

</html>

<?php
// Start the session
session_start();

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



$wordQuery = "SELECT randWord FROM randomWords ORDER BY RAND() LIMIT 1";


    
$getWord = $conn->query($wordQuery);
$words = "";

if($getWord->num_rows > 0){
    while($row = $getWord->fetch_assoc()){
        $words = $row["randWord"];
    }
}
    


if(!isset($_SESSION["emptyLines"])){
$_SESSION["count"] = 0;

$_SESSION["word"] = $words;
$_SESSION["len"] = strlen($_SESSION["word"]); 

$_SESSION["emptyLines"] = array();

$_SESSION["score"] = 0;

}



if(isset($_POST["restart"])){
   session_destroy();

   unset($_SESSION["count"]);
   unset($_SESSION["word"]);
   unset($_SESSION["len"]);

    $_SESSION["count"] = 0;

    $_SESSION["word"] = $words;
    $_SESSION["len"] = strlen($_SESSION["word"]);
    
    

    $_SESSION["emptyLines"] = array();

    $_SESSION["score"] = 0;
}


echo "The word is " . $_SESSION["len"] . " letters <br>";


?>

<?php


    if(isset($_POST["submitLetter"])){
        
        $_SESSION["score"]++;

    }
    

    if($_SESSION["count"] === 0){
        
        for ($i=0; $i<$_SESSION["len"] ;$i++)
        {
            $_SESSION["emptyLines"][$i] = "_";
            //echo "line 29 <br>";
        }

        $_SESSION["count"] = 1;
    }

    if(isset($_POST['submitLetter'])){

        $letter = $_POST['letter'];
        echo "The letter entered is " . $letter . "<br>";
        $_SESSION["count"] = $_SESSION["count"] +1;
    }
    

    //echo "$_SESSION["len"]" . " length is<br>"; 


    for($i=0; $i<$_SESSION["len"] ;$i++){

        if((strcmp(strval($letter), strval($_SESSION["word"][$i]))) === 0){
            $_SESSION["emptyLines"][$i] = $letter;
           
        }
        
    }

    // if(!isset($_SESSION["len"])) {
    //     echo "The word is " . $_SESSION["len"] . " letters <br>";
    // }

    //error: cannot print here
    // $val = arr_diff($_SESSION["word"], $_SESSION["emptyLines"]);
    // echo "arr_diff returns " . $val . "<br>";

    // $va = intval(strval($_SESSION["word"]) === strval($_SESSION["emptyLines"]));
    // echo "va is : " . $va . "<br>";
    // echo "strval word is: " . strval($_SESSION["word"]) . "<br>";
    // echo "strval word is: " . strval($_SESSION["emptyLines"]) . "<br>";
    
    for ($i=0; $i<$_SESSION["len"] ;$i++){

        if((strcmp(strval($_SESSION["emptyLines"][$i]), strval($_SESSION["word"][$i]))) != 0){
            
            //echo "strval emptylines is: " . strval($_SESSION["emptyLines"][$i]) . "<br>";
            //echo "strval word is..: " . strval($_SESSION["word"][$i]) . "<br>";
            break;
        }
        if($i === ($_SESSION["len"] -1) && ((strcmp(strval($_SESSION["emptyLines"][$i]), strval($_SESSION["word"][$i]))) === 0)){
            echo "game WON!! <br>";
            echo "Your score is: ".   $_SESSION["score"] . "<br>";
        }
    }

    foreach($_SESSION["emptyLines"] as $i){
        echo $i;
    }

?>


