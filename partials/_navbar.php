<?php
$userLoggedIn = false;
session_start();
if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == "true"){
  $userLoggedIn = true;
}
else{
  $userLoggedIn = false;
}
echo
'<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div style="background-color: black; height: 60px; margin-top: -10px;" class="container-fluid">
    <a style="color: white;" class="navbar-brand" href="/PhpForum">iDiscuss</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a style="color:white;" class="nav-link active" aria-current="page" href="/PhpForum">Home</a>
        </li>
        <li class="nav-item">
            <a style="color: white;" class="nav-link active" aria-current="page" href="about.php">About</a>
        </li>
        <li class="nav-item dropdown">
        <a style="color: white;" class="nav-link active dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          Topics
        </a><ul class="dropdown-menu">
        ';
        $sql = "SELECT * FROM `categories` LIMIT 5";
        $result = mysqli_query($conn,$sql);
        $numRows = mysqli_num_rows($result);
        for($i = 0; $i < $numRows; $i++){
          $rec = mysqli_fetch_assoc($result);
          echo '<li><a class="dropdown-item" href="threadlist.php?id='.$rec['category_id'].'">'.$rec['category_name'].'</a></li>';
        }
        echo '</ul></li>
        <li class="nav-item">
            <a style="color: white;" class="nav-link active" aria-current="page" href="contact.php">Contact</a>
        </li>
        </ul>';
if(!$userLoggedIn){
  echo'
  <div class="mx-3">
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#signupModal">Sign Up</button>
  </div>';
}
else{
  echo'
  <div style="display: flex;justify-content: center;align-items: center;margin: 90px;">
  <p style="margin-left:-30px;" class="text-light my-0" >Welcome</p>
  <p class="text-danger my-0 mx-2">'.$_SESSION['user_email'].'</p>
  </div>
  <div class="mx-3">
  <button type="button" id="logoutBtn" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#logoutBtn">Log out</button>
  </div>';
}
echo' 
<form class="d-flex" role="search">
  <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
  <button class="btn btn-outline-success" type="submit">Search</button>
  </form>
  </div>
  </div>
</nav>';
// Adding modal : 
include "partials/_loginmodal.php";
include "partials/_signupmodal.php";

if(isset($_GET['signUpSuccess'])){
  if($_GET['signUpSuccess'] == "false"){
    $showError = $_GET['error'];
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Error! </strong>'.$showError.'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
  }
  else if($_GET['signUpSuccess'] == "true"){
    $showError = $_GET['error'];
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>Congratulations! </strong>'.$showError.'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
  }
}


if(isset($_GET['loginSuccess'])){
  if($_GET['loginSuccess'] == "false"){
    $showError = $_GET['loginError'];
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Error! </strong>'.$showError.'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
  }
  else if($_GET['loginSuccess'] == "true"){
    $showError = $_GET['loginError'];
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>Congratulations! </strong>'.$showError.'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
  }
}
?>
