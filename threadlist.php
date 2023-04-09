<?php include "partials/_dbconnet.php" ?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>iDiscuss - Programming forums</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>
<style>
.custom-bg-secondary {
    background-color: #e9e5e5;
}
.anch{
    text-decoration: none;
    transition: all 0.2s;
}
.anch:hover{
    text-decoration: underline;
    background-color: rgb(240, 233, 233)
}
</style>

<body>
    <!-- Navbar :  -->
    <?php include "partials/_navbar.php"; ?>
    <!-- ThreadList page content :  -->
    <?php
        $id = $_GET['id'];
        $sql = "SELECT * FROM `categories` WHERE category_id = '$id'";
        $result = mysqli_query($conn,$sql);
        if(!$result){
          echo "Can't fetch categories";
        }
        else{
          for($i = 0; $i < mysqli_num_rows($result); $i++){
            $category = mysqli_fetch_assoc($result);
            $cateogry_name = $category["category_name"];
            $cateogry_description = $category["category_decription"];
            $category_id = $category["category_id"];
            echo '
            <div style="background-color: grey;" class="container my-5">
            <div class="container-fluid p-5 bg-light">
                <!-- bg-light is background color & p-5 is padding -->
                <h1 class="display-5">Welcome to '.$cateogry_name.' forums!</h1>
                <p class="lead">'.$cateogry_description.'</p>
                <hr class="my-4">
                <p>It uses utility classes for typography and spacing to space content out within the larger container.</p>
                <p class="lead">
                    <a id="user" class="btn btn-primary btn-lg" href="#" role="button">Learn more</a>
                </p>
            </div>
        </div>';
            }
        }
    ?>
    <!-- Form to ask questions :  -->
    <?php
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $t = $_POST['title'];
        $d = $_POST['description'];
        $email = $_SESSION['user_email'];
        $sql4 = "SELECT * FROM `users` WHERE user_email = '$email'";
        $result4 = mysqli_query($conn,$sql4);
        $res = mysqli_fetch_assoc($result4);
        $userId = $res['user_id'];
        $title = str_replace("'", "|", $t);
        $title = str_replace(">","&gt",$title);
        $description = str_replace("'", "|", $d);
        $description = str_replace(">","&gt",$description);
        // Insert the thread values into the database :
        $sql = "INSERT INTO `threads` ( `thread_title`, `thread_description`, `thread_category_id`, `thread_user_id`, `thread_date`) VALUES ('$title','$description', '$id', '$userId', CURRENT_TIMESTAMP)";
        echo $userId;
        $result = mysqli_query($conn,$sql);
        if(!$result){
            echo "Error! Couldn't insert thread into the database.",mysqli_error($conn);
        }
        else{

        }
    }
    ?>
    <?php
    // You can only start a discussion if the you are logged in :
    if($userLoggedIn){
        echo '<div class="container">
        <h3 class="text-center">Ask a question</h3>
        <form action="'. $_SERVER["REQUEST_URI"].'" method="post">
            <div class="mb-3">
                <label for="title" class="form-label">What is your problem about ?</label>
                <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
                <div id="emailHelp" class="form-text">Keep it as short as possible !</div>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Elaborate your problem</label>
                <textarea class="form-control" name="description" id="description" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Post question</button>
        </form>
        </div>';
    }
    else {
        echo '
        <div class="container">
            <h3 class="text-center display-6">Start a discussion</h3>
            <p class="lead my-4">You must be logged in to ask a question!</p>
        </div>
        ';

    }
    ?>
    <!-- Our Questions :  -->
    <div class="my-4 container">
        <h2 class="">Browse Questions</h2>
        <?php
        $noResult = true;
        $sql = "SELECT * FROM `threads` WHERE thread_category_id = '$id'";
        $result2 = mysqli_query($conn,$sql); 
        for($i = 0; $i < mysqli_num_rows($result2); $i++){
        $noResult = false;
        $thr = mysqli_fetch_assoc($result2);
        $thread_id = $thr['thread_id'];
        $thread_user_id = $thr['thread_user_id'];
        $thread_title = $thr['thread_title'];
        $thread_title = str_replace("|","'",$thread_title);
        $thread_description = $thr['thread_description'];
        $thread_description = str_replace("|","'",$thread_description);
        $thread_date = $thr['thread_date'];
        $date = new DateTime($thread_date);
        $formatted_date = $date->format('F j, Y, g:i A');
        $sql2 = "SELECT `user_email` FROM `users` WHERE user_id = '$thread_user_id'";
        $result3 = mysqli_query($conn,$sql2);
        $record = mysqli_fetch_assoc($result3);
        echo '<div class="d-flex my-5">
        <div class="flex-shrink-0">
            <img style="width: 60px; height: 60px;" src="imgs/anonymous.png" class="rounded-circle" alt="Sample Image">
        </div>
        <div class="flex-grow-1 ms-3">
            <h5><a class="anch text-danger" href="thread.php?thread_id='.$thread_id.'&thread_user_id='.$thread_user_id.'">'.$thread_title.'</a><small class="text-muted"><i class="mx-2">asked by <b class="text-primary">'.$record['user_email'].'</b> on '. $formatted_date.' </i></small></h5>
            <p class="text-secondary" >'.$thread_description.'</p></div></div>';
        }
        if($noResult){
            echo "<div class='container my-5'>
                <div class='container-fluid p-5 custom-bg-secondary'>
                    <!-- bg-light is background color & p-5 is padding -->
                    <h1 class='text-center display-5'>No Questions found!</h1>
                    <hr class='my-4'>
                    <p class='text-center my-3 display-8'>Be the first person to ask a question.</p>
                </div></div>";
        }
        ?>
    </div>
    <!-- Footer :  -->
    <?php include "partials/_footer.php"; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script>
</body>
<script>
let a = document.getElementById('user');
a.addEventListener("click", (event) => {
    event.preventDefault();
})
let logoutBtn = document.getElementById("logoutBtn");
  logoutBtn.addEventListener("click",(event) => {
    location.href = "/PhpForum/partials/_logout.php"
})
</script>

</html>

<!-- Posted on January 10, 2021 -->