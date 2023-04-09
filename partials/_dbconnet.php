<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "idiscuss";

// Connecting to the database : 
$conn = mysqli_connect($servername,$username,$password,$database);

if(!$conn){
    echo "Trouble connecting to the database ",mysqli_connect_error($conn);
}
?>