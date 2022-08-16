<?php 

$servername = "sql102.epizy.com";
$usernames = "epiz_31690301";
$passwords = "ETeo3AR4aBEqrD";
$dbname = "epiz_31690301_aalsarori";

$conn = new mysqli($servername, $usernames, $passwords, $dbname);


$sql = "INSERT INTO randomWords (randWord) VALUES ('carrot')";



if ($conn->query($sql) === TRUE) {
    echo "Account created successfully!";
} 
else {
echo "Error: " . $sql . "<br>" . $conn->error;
}

?>