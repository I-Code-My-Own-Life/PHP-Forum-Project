<?php
//Including the script to connect to the database :  
include "_dbconnet.php";
$method = $_SERVER['REQUEST_METHOD'];
$showError = false;
if($method = "POST"){
    $email = $_POST['signupEmail'];
    $password = $_POST['signupPassword'];
    $exists = false;
    // Check if the email already exits :
    $sql = "SELECT * FROM `users` WHERE user_email = '$email'";
    $result = mysqli_query($conn,$sql);
    $numRows = mysqli_num_rows($result);
    if($numRows > 0){
        $showError = "Email already exists";
        header("location: /PhpForum/?signUpSuccess=false&error=$showError");
    }
    else{
        $hash = password_hash($password,PASSWORD_DEFAULT);
        $sql = "INSERT INTO `users` (`user_email`, `user_password`, `user_timestamp`) VALUES ('$email', '$hash', CURRENT_TIMESTAMP)";
        $result = mysqli_query($conn,$sql);
        if(!$result){
            echo "Couldn't register user !",mysqli_error($conn);
        }
        else{
            $showError = "You are successfully registered and you can login now.";
            header("location: /PhpForum/?signUpSuccess=true&error=$showError");
            exit();
        }
    }
}   
?>