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
</style>

<body>
    <!-- Navbar :  -->
    <?php include "partials/_navbar.php"; ?>
    <!-- Fetching our question -->
    <?php
        $noResult = true;
        $id = $_GET['thread_id'];
        $sql = "SELECT * FROM `threads` WHERE thread_id = '$id'";
        $result = mysqli_query($conn,$sql);
        if(!$result){
          echo "Can't fetch categories";
        }
        else{
          for($i = 0; $i < mysqli_num_rows($result); $i++){
            $thread = mysqli_fetch_assoc($result);
            $thread_title = $thread["thread_title"];
            $thread_description = $thread["thread_description"];
            }
        }
    ?>
    <!-- Our problem :  -->
    <div style="background-color: grey;" class="container my-5">
        <div class="container-fluid p-5 bg-light">
            <!-- bg-light is background color & p-5 is padding -->
            <h1 class="display-5"><?php echo $thread_title; ?></h1>
            <p class="lead"><?php echo $thread_description; ?></p>
            <hr class="my-4">
            <?php
            // if(isset($_GET['']))
            $thread_user_id = $_GET['thread_user_id'];
            $sql2 = "SELECT `user_email` FROM `users` WHERE user_id = '$thread_user_id'";
            $result3 = mysqli_query($conn,$sql2);
            $record = mysqli_fetch_assoc($result3);
            $email = $record['user_email'];
            $user = explode("@", $email)[0];
            echo '
            <p class="lead">
                <button style="width: max-content; height:50px; font-size:15px;" class="btn btn-primary btn-lg">Posted by : '.$user.'</button>
            </p>';
            ?>
        </div>
    </div>
    <!-- Form to add comments :  -->
    <?php
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $time = 'CURRENT_TIMESTAMP';
        if(session_status() === PHP_SESSION_NONE){
            session_start();
        }
        $user = $_SESSION['user_email'];
        $content = $_POST['content'];
        $content = str_replace("<","&lt",$content);
        $content = str_replace(">","&gt",$content);
        // Prepare the query statement 
        $stmt = mysqli_prepare($conn, "INSERT INTO `comments` (`comment_content`, `comment_thread_id`, `comment_time`,`comment_by`) VALUES (?, ?, $time, ?)");

        // Bind the parameters
        mysqli_stmt_bind_param($stmt, 'sis', $content, $id, $user);

        // Execute the query
        $result = mysqli_stmt_execute($stmt);

        if(!$result){
            echo "Error! Couldn't insert comment into the database.",mysqli_error($conn);
        }
        else{

        }
    }
    ?>
    <?php
    if($userLoggedIn){
        echo '<div class="container">
        <h3 class="">Add a comment</h3>
        <form action="'. $_SERVER["REQUEST_URI"].'" method="post">
            <div class="mb-3">
                <label for="content" class="form-label"></label>
                <textarea placeholder="Type your comment here" class="form-control" name="content" id="content" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary my-3 mx-2">Post Comment</button>
        </form>
        </div>';
    }
    else {
        echo '
        <div class="container">
            <h3 class="text-center display-6">Post a comment</h3>
            <p class="lead my-4">You must be logged in to post a comment!</p>
        </div>';
    }
    ?>
    <!-- Our comments :  -->
    <div class="my-4 container">
        <h2>Comments</h2>
        <?php
        $sql = "SELECT * FROM `comments` WHERE comment_thread_id = '$id'";
        $result2 = mysqli_query($conn,$sql); 
        for($i = 0; $i < mysqli_num_rows($result2); $i++){
        $noResult = false;
        $comment = mysqli_fetch_assoc($result2);
        $comment_id = $comment['comment_id'];
        $commment_content = $comment['comment_content'];
        $comment_time = $comment['comment_time'];
        $date = new DateTime($comment_time);
        $formatted_date = $date->format('F j, Y, g:i A');
        $comment_by = $comment['comment_by'];
        echo '<div class="d-flex my-5">
        <div class="flex-shrink-0">
            <img style="width: 60px; height: 60px;" src="imgs/anonymous.png" class="rounded-circle" alt="Sample Image">
        </div>
        <div class="flex-grow-1 ms-3">
            <h5 class="text-dark">'.$comment_by.'<small class="text-muted"><i class="mx-2"> posted on '. $formatted_date.'</i></small></h5>
            <p>'.$commment_content.'</p></div></div>';
        }
        if($noResult){
            echo "<div class='container my-5'>
                <div class='container-fluid p-5 custom-bg-secondary'>
                    <!-- bg-light is background color & p-5 is padding -->
                    <h1 class='text-center display-5'>No comments found!</h1>
                    <hr class='my-4'>
                    <p class='text-center my-3 display-8'>Be the first person to comment.</p>
            </div></div>";}
        ?>
    </div>
    <!-- Footer : -->
    <?php include "partials/_footer.php"; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script>
</body>
<script>
    let logoutBtn = document.getElementById("logoutBtn");
    logoutBtn.addEventListener("click",(event) => {
        location.href = "/PhpForum/partials/_logout.php";
    })
</script>
</html>
<!-- <p style="width: max-content;"></p> -->