<?php
//Including the script to connect to the database :  
include "_dbconnet.php";
$method = $_SERVER['REQUEST_METHOD'];
$showErrorLogin = false;
if($method = "POST"){
    $email = $_POST['loginEmail'];
    $password = $_POST['loginPassword'];
    $sql = "SELECT * FROM `users` WHERE user_email = '$email'";
    $result = mysqli_query($conn,$sql);
    $numRows = mysqli_num_rows($result);
    if($numRows == 1){
        $res = mysqli_fetch_assoc($result);
        // Verifying password : 
        if(password_verify($password,$res['user_password'])){
            $showErrorLogin = "You are successfully logged in.";
            // Starting our user session : 
            session_start();
            $_SESSION['loggedIn'] = true;
            $_SESSION['user_email'] = $email;
            header("location: /PhpForum/?loginSuccess=true&loginError=$showErrorLogin");
        }
        else{
            $showErrorLogin = "Your password is incorrect";
            header("location: /PhpForum/?loginSuccess=false&loginError=$showErrorLogin");
        }
    }
    else{
        $showErrorLogin = "Email does not exist";
        header("location: /PhpForum/?loginSuccess=false&loginError=$showErrorLogin");
    }
}
?>